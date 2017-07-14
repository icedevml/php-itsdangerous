# php-itsdangerous
A very simple library which resembles basic functionality of Python's itsdangerous module. Two functions are provided:

```php
// take $data, serialize it with JSON, append a HMAC signature to it and finally base64-encode it
Signing::sign_dump($data, $secret, $hash_func='sha256')

// do the reverse: decode base64, read and validate the signature and unserialize JSON-encoded data
Signing::load($data, $secret, $hash_func='sha256')
```

Works with any data that could be succesfully JSON serialized/unserialized.

A user which has got a token generated with `Signing::dump`:
* **can** figure out the original data which is signed (unless you encrypt it with AES prior to signing or do something similiar)
* **can not** tamper the data, as this will make signature invalid, so `Signing::load` will throw `InvalidSignatureException` upon loading
* **can not** generate another token by himself, assuming that he doesn't know the shared secret value (in this case: `some_random_secret`)

## Example:
```php
use IceDev\itsdangerous\Signing;

$s = new Signing('some_random_secret');

$s->dump(['foo', 'bar']);
// returns: string(104) "WyJmb28iLCJiYXIiXS41ZTkxYjQ3M2E1MmEwNDg3YWNhZGM4MGExYjQwYjIwNDM4NThjODg2NjI3ZDNiODM5OTIzN2E4ZTM1ZGM2ZmIy"

$s->load('WyJmb28iLCJiYXIiXS41ZTkxYjQ3M2E1MmEwNDg3YWNhZGM4MGExYjQwYjIwNDM4NThjODg2NjI3ZDNiODM5OTIzN2E4ZTM1ZGM2ZmIy');
// returns: array(2) { [0]=> string(3) "foo", [1]=> string(3) "bar" }
```
