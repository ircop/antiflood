# Small antiflood system for Laravel

This tool designed for simple limiting some user requests.
It makes it easy to add some protection from DB ddos or bruteforce attack.


## INSTALL

1: install via composer

```
composer require ircop/antiflood
```

2: add service provider to `providers` array in `config/app.php`:
```
Ircop\Antiflood\AntifloodServiceProvider::class,
```

3: add facade alias to `aliases` array in `config/app.php`:
```
'Antiflood' => Ircop\Antiflood\Facade\Antiflood::class,
```



## Usage

Checking for record existance with given ident.

Ident can be ip-address, login, anything unique.

$maximum - is maximum allowed value for this ident. Default is 1.

```php
\Antiflood::check( $ident, $maximum = 1 );

// Or with IP identity

\Antiflood::checkIP( $maximum = 1 );
```


Putting record for given ident on given $minutes:
```php
\Antiflood::put( $ident, $minutes = 10 );

// Or with IP identity

\Antiflood::putIP( $minutes = 10 );
```

## Examples:

#### Limiting wrong login attempts for given IP address:


This example limiting wrong login attempts from one ip-address to 5 tryes per 20 minutes:
```
public function postLogin()
{
	$key = $_SERVER['REMOTE_ADDR'];
	
	// If this ip has >= 5 failed login attempts in last 20 minutes, redirect user
	// back with error:
	if( \Antiflood::check( $key, 5 ) === FALSE )
		return redirect()->back()->withErrors(['Too many login attempts! Try again later.']);
	
	// ....
	// ....
	// ....

	// After failed login put user ipaddr to antiflood cacte on 20 min.
	// If there is no records with this ident, record will be added with value=1, else
	// it will be increased.
	\Antiflood::put( $key, 20 );
}
```


#### Limiting password recovery for 1 try per 30 min.

This code shows how to limit some functions like email, etc. to prevend flood from our server, for example.
```
public function postPasswordRecover()
{
	$key = \Input::get('email');
	if( \Antiflood::check( $key ) === FALSE )
		return redirect()->back()->withErrors(['.....']);
	
	// ....
	// ....
	// ....

	\Antiflood::put( $key, 20 );
}
```

