# CRUD model

This model will help you to create CRUD models for your entitites, and provides you a huge set of methods after a simpe setup.

## Installation

Just print in console

```
composer require mezon/crud-service-model
```

And that's all )

## First steps

Let's define a new class for your DB entity:

```php
class EntityModel extends CrudServiceModel
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('*', 'entity_table_name');
	}
}
```

In this exact line of code:

```php
parent::__construct('*', 'entity_table_name');
```

We have specified that we need `'*'` (all fields) from the table with name `'entity_table_name'`.

If you need only some fields from your database, just list them in the first parameter:

```php
parent::__construct('id,field1,field2,field3', 'entity_table_name');
```

And when you have done this, you will get the following methods.

But before using these methods note that you will need to meet the requirements for some naming conventions.

Field with the primary key must be named as `id`. I shall add setting to use another name.

Some methods reqire field `creation_date` for fetching new records for example.

You may add to the table field `domain_id` for implementing multy instancing out of the box.

Now lets look at available methods:

```php
// Method fetches all new records since the $date
// For example $model->newRecordsSince($domainId, '2021-01-01');
newRecordsSince($domainId, string $date): array;
```

```php
// Method calculates count of records fetched by filter
// For example $model->recordsCount(false, ['field1 = 1', 'field2 = 2']);
recordsCount($domainId = false, array $where = ['1=1']);
```

```php
// Method returns data as is without any transformations
getSimpleRecords($domainId, int $from, int $limit, array $where, array $order = []): array;
```

```php
// Method returns records wich are transformed by method getRecordsTransformer wuch 
// you can override in your subclass
getRecords($domainId, int $from, int $limit, array $where = ['1=1'], array $order = []): array;
```

```php
// Method returns the last $count records filtered by where
lastRecords($domainId, $count, $where): array;
```

```php
// Method returns records by their ids
fetchRecordsByIds($domainId, string $ids): array;
```

```php
// Method calculates count of records grouped by fieldName and filtered by where
recordsCountByField($domainId, string $fieldName, array $where): array;
```

```php
// Method updates records with values record
updateBasicFields($domainId, array $record, array $where): array;
```

```php
// Method inserts record record
insertBasicFields(array $record, $domainId = 0): array;
```

```php
// Method deletes all records filtered by where
deleteFiltered($domainId, array $where): int;
```