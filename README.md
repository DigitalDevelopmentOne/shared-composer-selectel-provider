# selectel-transmitter
File transmitter to selectel (S3 object storage).

## Installation
This project using composer.
```
$ composer require llpddone/selectel-transmitter
```

Run
```
$ php artisan vendor:publish
```

Use
```php

$file = $request->file('YOUR_KEY');
 
$outputFileName = time();
$inputExtension = $file->extension();
$inputFileName = $file->getFilename()

SelectelTransmitter::saveFile(
    inputPath: '/tmp',
    inputFileName: 'fileName',
    outputFileName: $outputFileName . '.' . $inputExtension
);

```
Fill in the properties in .env according to the keys from the config or change the configuration.