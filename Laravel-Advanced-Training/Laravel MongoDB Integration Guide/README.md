Laravel supports MongoDB integration through the use of community packages like [jenssegers/laravel-mongodb](https://github.com/jenssegers/laravel-mongodb). This package allows you to interact with MongoDB in a way similar to how Eloquent ORM works with SQL databases. Here's a guide to setting it up:

### Installation
1. **Install the package via Composer:**
   ```bash
   composer require jenssegers/mongodb
   ```

2. **Configure MongoDB in `config/database.php`:**
   Add a MongoDB connection in the `connections` array:
   ```php
   'connections' => [
       'mongodb' => [
           'driver'   => 'mongodb',
           'host'     => env('DB_HOST', '127.0.0.1'),
           'port'     => env('DB_PORT', 27017),
           'database' => env('DB_DATABASE', 'homestead'),
           'username' => env('DB_USERNAME', ''),
           'password' => env('DB_PASSWORD', ''),
           'options'  => [
               'database' => env('DB_AUTH_DATABASE', 'admin'), // Optional for authentication
           ],
       ],
       // other connections...
   ],
   ```

3. **Set the default database connection (optional):**
   Update your `.env` file:
   ```env
   DB_CONNECTION=mongodb
   DB_HOST=127.0.0.1
   DB_PORT=27017
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

### Using MongoDB with Eloquent
1. **Extend `Jenssegers\Mongodb\Eloquent\Model`:**
   Replace the default `Illuminate\Database\Eloquent\Model` with the MongoDB model in your models.
   ```php
   use Jenssegers\Mongodb\Eloquent\Model;

   class User extends Model
   {
       protected $connection = 'mongodb';
       protected $collection = 'users'; // Optional
   }
   ```

2. **Perform Queries:**
   Use the Eloquent methods as usual:
   ```php
   // Create a new user
   User::create(['name' => 'John Doe', 'email' => 'john@example.com']);

   // Retrieve all users
   $users = User::all();

   // Find a user by ID
   $user = User::find('mongo_id_here');

   // Update a user
   $user->update(['email' => 'newemail@example.com']);

   // Delete a user
   $user->delete();
   ```

### Migrations
MongoDB does not use strict schemas, but you can still use Laravel migrations for organization:
```php
use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;

class CreateUsersCollection extends Migration
{
    public function up()
    {
        Schema::connection('mongodb')->create('users', function (Blueprint $collection) {
            $collection->index('email');
            $collection->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mongodb')->drop('users');
    }
}
```

### Features
- **Embedded documents:** Work with nested documents as arrays or objects.
- **Query Builder:** Use MongoDB's powerful querying capabilities through Laravel's query builder.

### Useful Links
- **Official Documentation:** [GitHub - Jenssegers Laravel MongoDB](https://github.com/jenssegers/laravel-mongodb)
- **MongoDB Atlas (Cloud Database):** [Atlas](https://www.mongodb.com/atlas/database) 

Let me know if you need help with a specific MongoDB feature or integration!