# Steps of tenancy installation:

1. Setup .env variables:
 - `APP_DOMAIN` - you local website domain (like example.local);
 - `SUPPORT_PROFILE_EMAILL=support@ibex-consulting.co.uk`;
 - ensure that APP_ENV is not roduction or live.

2. Add subdomain foo.your-domain-name to hosts file and direct it to the same IP you have for you local server now (your-domain-name  - is the domain you specified in `APP_DOMAIN` env variable).

3. Ensure that you still can open website by you regular website link (your-domain-name).

4. If previous step works - now actually tenant creating process:
 - open tinker `php artisan tinker`;
 - run command `Profile::factory()->withSubscription('test123', true)->create(['organisation' => 'foo1'])`
   (in array `['organisation' => 'foo1']`  you can also specify email you would like to use for the profile. If all goes well - you'll see the resulting array of data for created profile).

5. After that you can open `foo.your-domain-name` (don't forget to replace `your-domain-name`) and login with the email that was generated and password `das4jvDas_8va3jVhd`.