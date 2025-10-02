FROM bitnami/laravel:11.0.6

WORKDIR /app

COPY . .

RUN composer install && \
    npm install && \
    npm run build

RUN apt-get update && \
    apt-get install -y netcat-openbsd git && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN chmod +x ./entrypoint.sh

CMD [ "./entrypoint.sh" ]
