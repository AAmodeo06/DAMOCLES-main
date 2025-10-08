<?php
// Realizzato da: Luigi La Gioia

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Notification;
use App\Models\Role;

class NotificationsTest extends DuskTestCase
{
    public function test_user_can_view_and_mark_notifications_as_read()
    {
        $role = Role::factory()->create(['name' => 'Impiegato']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $notification = Notification::create([
            'user_id' => $user->id,
            'message' => 'Nuova campagna assegnata!',
            'read_at' => null
        ]);

        $this->browse(function (Browser $browser) use ($user, $notification) {
            $browser->loginAs($user)
                    ->visit('/notifications')
                    ->assertSee('Nuova campagna assegnata!')
                    ->press('Segna come letta')
                    ->waitForText('Notifica segnata come letta')
                    ->refresh()
                    ->assertDontSee('Segna come letta');
        });
    }
}
