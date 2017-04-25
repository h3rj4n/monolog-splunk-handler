Monolog Splunk Handler
===

Simple monolog wrapper for the Easylo Splunk SDK.

*How to use*

```php
use flyandi/Monolog/Handler/SplunkHandler;
```

*Invoke Handler*
```php
$handlers[] = new SplunkHandler(
    (string) <Source>,
    (array, optional) <ConnectionParameters>,
    (array, optional) <OptionalParameters>,
    (const, optional) level,
    (boolean, optional) bubble 
);
```

Connection Parameters
---

Connection parameter is an array with various options. It supports all connection variants for Splunk including user and token authentication.

**username**: (optional) The username to login with. Defaults to "admin".

**password**: (optional) The password to login with. Defaults to "changeme".
 
**token**: (optional) The authentication token to use. If provided, the username and password are ignored and there is no need to call login(). In the format `Splunk SESSION_KEY`.

**host**: (optional) The hostname of the Splunk server. Defaults to "localhost".

**port**: (optional) The port of the Splunk server. Defaults to 8089.

**scheme**: (optional) The scheme to use: either "http" or "https". Defaults to "https".

**namespace**: (optional) Namespace that all object lookups will occur in by default. Defaults to `Splunk_Namespace::createDefault()`.

**http**: (optional) An Http object that will be used for performing HTTP requests. This is intended for testing only.


Optional Parameters
---

Optional parameters are included in every log. This is useful if you want to log additional items like user or session data.

*Example*
```php
    $data = [
        "user" => "Foo",
        "environment" => "Production",
        "version" => "1.0",
        "remoteBrowser" => $env["HTTP_USER_BROWSER"]
    ];
```
