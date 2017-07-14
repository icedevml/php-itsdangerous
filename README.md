# php-itsdangerous
A very simple library which resembles basic functionality of Python's itsdangerous module. Two functions are provided:

```php
// take $data, serialize it with JSON, append a HMAC signature to it and finally base64-encode it
sign_dumps($data, $secret, $hash_func='sha256')

// do the reverse: decode base64, read and validate the signature and unserialize JSON-encoded data
sign_loads($data, $secret, $hash_func='sha256')
```

Works with any data that could be succesfully JSON serialized/unserialized.

A user which has got a token generated with `sign_dumps`:
* **can** figure out the original data which is signed (unless you encrypt it with AES prior to signing or do something similiar)
* **can not** tamper the data, as this will make signature invalid, so `sign_loads` will throw `InvalidSignatureException` upon loading
* **can not** generate another token by himself, assuming that he doesn't know the shared secret value (in this case: `some_random_secret`)

## Example:
```php
sign_dumps(['foo', 'bar'], 'some_random_secret');
// returns: string(104) "WyJmb28iLCJiYXIiXS41ZTkxYjQ3M2E1MmEwNDg3YWNhZGM4MGExYjQwYjIwNDM4NThjODg2NjI3ZDNiODM5OTIzN2E4ZTM1ZGM2ZmIy"

sign_loads('WyJmb28iLCJiYXIiXS41ZTkxYjQ3M2E1MmEwNDg3YWNhZGM4MGExYjQwYjIwNDM4NThjODg2NjI3ZDNiODM5OTIzN2E4ZTM1ZGM2ZmIy', 'some_random_secret');
// returns: array(2) { [0]=> string(3) "foo", [1]=> string(3) "bar" }
```
