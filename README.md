# Password migration issue

The dummy user's credentials:

- Username: `test@test.com`
- Password: `secret`

## Setup

1. Run `make up` to start the Docker containers
2. Run `make setup-database` to create the DB schema and load fixtures
3. The app is available at `http://localhost:8080`

## Flow 1:

1. Go to `http://localhost:8080/login`
2. Log in using the credentials from above

Symfony will use `legacy_md5_password_encoder` because the User entity implements `PasswordHasherAwareInterface`. The legacy hasher's `needsRehash` always returns true so Symfony will re-hash the user's plaintext password using the legacy hasher.

## Flow 2:

1. Remove the `PasswordHasherAwareInterface` implementation from `src/Entity/User.php`
2. Go to `http://localhost:8080/login`
3. Log in using the credentials from above

Symfony will now use `vendor/symfony/password-hasher/Hasher/MigratingPasswordHasher.php` to verify the given password because it doesn't seem to know this user needs to use the legacy hasher. Login fails due to usage of wrong hasher.
