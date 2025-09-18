<?php

namespace Tests\Feature;

use App\Http\Controllers\TodayController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TodayWorkflowTest extends TestCase
{
    public function test_normalise_form_fields_converts_arrays_checkboxes_and_files(): void
    {
        Storage::fake('public');

        $user = $this->fakeUser();
        auth()->setUser($user);

        $controller = app(TodayController::class);

        $request = Request::create('/today/store', 'POST', [
            'activity_date' => now()->toDateString(),
            'work_office' => ['09:00', '10:00'],
            'work_soho' => ['13:00'],
            'work_3pl' => [],
            'life' => ['家事'],
            'move' => ['通勤'],
            'green_power' => 'on',
            'light_led_office' => 'on',
            'move_walk' => 'on',
        ], [], [
            'breakfast_image' => UploadedFile::fake()->create('breakfast.jpg', 10, 'image/jpeg'),
        ]);

        $normalised = $this->callNormalise($controller, $request);

        $this->assertSame($user->id, $normalised['user_id']);
        $this->assertSame('09:00,10:00', $normalised['work_office']);
        $this->assertSame('13:00', $normalised['work_soho']);
        $this->assertSame('', $normalised['work_3pl']);
        $this->assertSame('家事', $normalised['life']);
        $this->assertSame('通勤', $normalised['move']);
        $this->assertSame('1', $normalised['green_power']);
        $this->assertSame('1', $normalised['light_led_office']);
        $this->assertSame('0', $normalised['light_led_soho']);
        $this->assertSame('0', $normalised['light_led_3pl']);
        $this->assertSame('1', $normalised['move_walk']);

        $this->assertArrayHasKey('breakfast_image', $normalised);
        Storage::disk('public')->assertExists($normalised['breakfast_image']);
    }

    public function test_normalise_form_fields_defaults_to_zero_for_unchecked_inputs(): void
    {
        $user = $this->fakeUser();
        auth()->setUser($user);

        $controller = app(TodayController::class);

        $request = Request::create('/today/store', 'POST', [
            'work_office' => [],
            'life' => [],
            'move' => [],
        ]);

        $normalised = $this->callNormalise($controller, $request);

        $this->assertSame('', $normalised['work_office']);
        $this->assertSame('', $normalised['life']);
        $this->assertSame('', $normalised['move']);
        $this->assertSame('0', $normalised['green_power']);
        $this->assertSame('0', $normalised['light_led_office']);
        $this->assertSame('0', $normalised['light_led_soho']);
        $this->assertSame('0', $normalised['light_led_3pl']);
        $this->assertSame('0', $normalised['move_walk']);
    }

    private function callNormalise(TodayController $controller, Request $request): array
    {
        $method = (new \ReflectionClass($controller))->getMethod('normaliseFormFields');
        $method->setAccessible(true);

        return $method->invoke($controller, $request);
    }

    private function fakeUser(): User
    {
        $user = new User();
        $user->id = 999;

        return $user;
    }
}
