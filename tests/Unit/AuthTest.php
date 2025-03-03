<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\UserSeeder;
use Spatie\Permission\Models\Role;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected $adminUser;
    public function setUp(): void
    {
        parent::setUp();

        // Jalankan UserSeeder untuk data awal
        $this->seed(UserSeeder::class);

        // Ambil user admin dari seeder untuk keperluan test
        $this->adminUser = User::where('email', 'admin@gmail.com')->first();
    }


    /**
     * Test registration screen can be rendered
     */
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200)
                 ->assertViewIs('auth.register');
    }


    /**
     * Test new users can register
     */
    public function test_new_users_can_register()
    {
        $peminjamRole = Role::where('name', 'peminjam')->first();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name' => 'Test User',
            'role_id' => $peminjamRole->id, // Gunakan ID dinamis dari seeder
        ]);

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }


    /**
     * Test registration fails with duplicate email
     */
    public function test_registration_fails_with_duplicate_email()
    {
        $response = $this->post('/register', [
            'name' => 'Duplicate User',
            'email' => 'admin@gmail.com', // Email dari seeder
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }


    /**
     * Test login screen can be rendered
     */
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200)
                 ->assertViewIs('auth.login');
    }


    /**
     * Test users can authenticate using the login screen
     */
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '123123123', // Password dari seeder
        ]);

        $response->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($this->adminUser);
        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id,
            'status' => 'Online',
        ]);
        $this->assertDatabaseHas('user_activity_logs', [
            'user_id' => $this->adminUser->id,
            'activity' => 'login',
        ]);
    }


    /**
     * Test users cannot authenticate with invalid password
     */
    public function test_users_cannot_authenticate_with_invalid_password()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test users can logout
     */
    public function test_users_can_logout()
    {
        $this->actingAs($this->adminUser);

        $response = $this->post('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'id' => $this->adminUser->id,
            'status' => 'Offline',
        ]);
        $this->assertDatabaseHas('user_activity_logs', [
            'user_id' => $this->adminUser->id,
            'activity' => 'logout',
        ]);
    }
}
