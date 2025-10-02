#!/bin/bash

set -o errexit
set -o nounset
set -o pipefail

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! nc -z mysql 3306; do
  sleep 1
done
echo "MySQL is ready"

# Check if migrations and seeding have already been done
echo "Checking if migrations and seeding are needed..."

set +e
php -r "
require 'vendor/autoload.php';
require 'bootstrap/app.php';

use Illuminate\Support\Facades\Schema;

app()->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

exit(Schema::hasTable('users') ? 0 : 1);
"
retval=$?

if [ "$retval" -eq 1 ]; then
  echo 'Starting Laravel migration and seeding process...'
  php artisan migrate --force
  php artisan db:seed --force
  echo 'Migration and seeding completed successfully.'
else
  echo 'Migrations and seeding already done, skipping.'
fi

set -e

# Generate the application key
php artisan key:generate

# Run the queue and schedule workers
php artisan queue:work &
php artisan schedule:work &

php artisan serve --host=0.0.0.0 --port=8000 &

npm run dev
