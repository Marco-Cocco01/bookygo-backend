<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\Timeout;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\Attributes\MaxExceptions;
use App\Models\User;



#[Tries(5)]
#[Timeout(120)]
#[MaxExceptions(3)]
class BusinessUserInvite extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        $this->user = $user;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(config('app.name') . ' | Sei stato invitato a unirti al nostro team')
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->greeting('Ciao,' . $this->user->name . '!')
            ->line('Sei stato invitato a unirti al nostro team.')
            ->line('Se vuoi, puoi accettare l\'invito e attivare il tuo account.')
            ->line('Clicca sul pulsante o sul link qui sotto.')
            ->action('Attivavazione Account', url('login'))
            ->line('Lo staff di ' . config('app.name') . ' ti ringrazia per aver scelto il nostro servizio!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message'      => 'L\'utente ' . $this->user->name . ' è stato invitato a unirsi alla Business Unit.',
            'user_id'   => $this->user->id,
            'user_name' => $this->user->name,
            'action_url'=> route('contacts.index', $this->user->id), // Opzionale: per il link diretto
        ];
    }
}
