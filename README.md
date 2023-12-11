# EncoreDigitalGroup.DynamicData
This package is designed to allow you to create dynamic data objects that can be used in your code.
This is useful for when you need to store user defined information in a standard but still flexible structure.

## Installation
```bash
composer require encoredigitalgroup/dynamicdata
```

## Creating a new Dynamic Data Object
Let's create a Dynamic Data Object for someone's favorite TV Show
```php
<?php

use EncoreDigitalGroup\DynamicData\Helpers\DynamicData

$ddo = new DynamicData()

$ddo->setName('favoriteTvShow');
$ddo->setType('string');
$ddo->setLabel('Favorite TV Show');
$ddo->setValue('Suits');
$ddo->setExternal();
$ddo->setRequired(false);
$ddo->setShallEncrypt(false);

//Build the Object as an Array
$ddo->buildAsArray();
//or
$ddo->build(); //build() is a wrapper for buildAsArray()

//Build the Object as a JSON String
$ddo->buildAsJson() //buildAsJson() is a wrapper for buildAsArray() that also runs json_encode() prior to returning the encoding JSON String
```
In the above example, we did not utilize every method to set every field, such as `setIsEncrypted`, as the default value of `setIsEncrypted` is `false`. We also instructed `DynamicData` not to encrypt the value supplied to `setValue`.
As you would expect, any optional field that is not defined on the `DynamicData()` object, will be set to `null` when any `build()` method is called.

## Field Information
|Field Name     |Required|Default Value|
|---            |---     |---          |
|Name           |✅     |              |
|Type  	        |❌     |`null `       |
|Label 	        |✅     |              |
|Value 	        |❌     |`null`        |
|Source.Name    |❌     |`null`        |
|Source.Scope 	|❌     |`null`        |
|External     	|❌     |`true`        |
|Required 	    |❌     |`false`       |
|Excrypted.Is 	|❌     |`false`       |
|Encrypted.Shall|❌     |`false`       |


## Dynamic Data JSON Structure
Here is an example of what a dynamic data field looks like:

```json
{
  "your_custom_field": {
    "name": "string (required)",
    "type": "string|null",
    "label": "string (required)",
    "value": "string|null",
    "source": {
      "name": "mixed|null",
      "scope": "mixed|null"
    },
    "external": "bool (required)",
    "required": "bool (required)",
    "encrypted": {
      "is": "bool (required)",
      "shall": "bool (required)"
    }
  }
}
```
The `your_custom_field` key is the name of the field.
This is used to identify the field in your code quickly rather than needing to loop over
each item checking the name of the field.

The `name` key inside of `your_custom_field` should be the same value as the key in which it resides.
This is used so you can easily use this field name in your code should you need it.

The `type` key is used to identify what type of field this is. Encore Digital Group uses this field to determine what blade component
should be used when rendering this field.

The `label` key is used to display a label to the user when they are editing this field.

The `source.name` key is used to identify where the data for this field lives. Encore Digital Group uses this field to
determine what third party API to use to retrieve the data for this field.

The `source.scope` key is used to identify what scope to apply to the data source. For instance, if you need to add additional logic
to the data source to retrieve the data, you can use this field to identify what scope to apply in you code.

The `external` key is used to determine if this field should be displayed to users.

The `required` key is used to determine if the user is required to provide a value to the field.

The `encrypted.is` key is used to determine if the value of the field is currently encrypted. More than likely,
 `encrypted.is` will be `true` if `encrypted.shall` is `true`. However, if a value has never been set for this field, then `encrypted.is` will be `false`.

The `encrypted.shall` key is used to determine if the value of the field should be encrypted. If `encrypted.shall` is `true`, then when the dynamic data is being
encoded, this package will encrypt this field using you Laravel `APP_KEY`.
