# Query Builder
## Khởi tạo đối tượng
```php
$db = DB::getInstance();
```
## Insert dữ liệu vào database
```php
$db->insert('user',
	[
		'first_name' => 'Marei',
		'last_name' => 'Morsy',
		'age'	=> 22
	]);
```
- Để xem câu lệnh SQL thì dùng phương thức `getSQL()`
```php
echo $db->getSQL();
```
Output :
```sql
INSERT INTO `user` (`first_name`, `last_name`, `age`) VALUES (?, ?, ?)
```
## Update dữ liệu

```php
$db->update('user',
	[
		'first_name' => 'Mohammed',
		'last_name' => 'Gharib',
		'age'	=> 24
	],1);
```
```sql
UPDATE `user` SET `first_name` = ?, `last_name` = ?, `age` = ? WHERE `user`.`id` = ?
```

- Hoặc
```php
$db->update('user',
	[ 
		'first_name' => 'Zizo',
		'last_name' => 'Atia',
		'age'	=> 23
	],['age','>',22]);
```

```sql
UPDATE `user` SET `first_name` = ?, `last_name` = ?, `age` = ? WHERE `user`.`age` > ?
```

## Sử dụng method `where()`

```php
$db->update('user',
	[
		'first_name' => 'Ashraf',
		'last_name' => 'Hefny',
		'age'	=> 28
	])->where('id', 1)->exec();
```

```sql
UPDATE `user` SET `first_name` = ?, `last_name` = ?, `age` = ? WHERE `user`.`id` = ?
```
## Xóa

### Cách 1
```php
$db->delete('user', ['first_name', 'Marei']);
```

```sql
DELETE FROM `user` WHERE `user`.`first_name` = ?
```

### Cách 2
```php
$db->delete('user', ['age', '<', 18]);
```

```sql
DELETE FROM `user` WHERE `user`.`age` < ?
```