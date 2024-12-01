<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use App\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ticketCode = $this->faker->unique()->bothify('TICKET-####-????');

        // Configurar las opciones del QR
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_H,
            'scale' => 5,
        ]);

        $qrCode = (new QRCode($options))->render($ticketCode);

        $event = Event::select('id')->inRandomOrder()->first();

        return [
            'event_id' =>  $event->id,
            'ticket_code' => $this->faker->unique()->bothify('TICKET-####-????'),
            'qr_code' => base64_encode($qrCode), 
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
