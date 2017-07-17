SimpleQuery
===========

example of use:
**connect to db**
```
$sq = new SimpleQUery('localhost', 'db', 'root', 'password');
```
 **select all**
```
$rs = $sq->getAll('m_user');
```
>SELECT * FROM m_user

**get one record by id**
```
$rs = $sq->getOneById('m_user', array('user_id' => 1));
```
>SELECT * FROM m_user WHERE user_id = 1

```
$rs = $sq->getOneById('m_user', 4);
```
>SELECT * FROM m_user WHERE id = 4

**get first record**
```
$rs = $sq->getFirst('m_user', 'user_id');
```
>SELECT * FROM m_user ORDER BY user_id ASC LIMIT 1

**get last record**
```
$rs = $sq->getLast('m_user', 'user_id');
```
>SELECT * FROM m_user ORDER BY user_id DESC LIMIT 1

**get all records by parameters**
```
$rs = $sq->getAllByParams('m_user',
		array(
			'name' => array('jo', 'like', 'and'),
			'is_active' => array(0, '=')
		)
	);
```
>SELECT * FROM m_user WHERE name LIKE '%jo%' AND is_active = 0