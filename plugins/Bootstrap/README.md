# Grid3 plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

1. The recommended way to install composer packages is:
```sh
composer require adrianodemoura/Grid3
```

2. In your controller to load component:

```php
// carregando o componente filtro
$arrSchema = 
[
	'Table1.field' 		=> ['table'=>true, 'title'=>'titleField',   'filter'=>true, 'order'=>true],
	'Table1.field2' 	=> ['table'=>true, 'title'=>'tiel2Field', 	'operator'=>'like', 'mask'=>'%u%'],
	'Table2.field' 		=> ['table'=>true, 'title'=>'titleField']
];
$this->loadComponent( 'Bootstrap.Filtro', ['schema'=>$arrSchema] );
```

3. In you view to load helper (file .ctp):
```php
$this->loadHelper('Bootstrap.Schema', ['schema'=>$schema]);
```

To configure table, you can:

```php
$this->Schema->set('Table.field.tag', ['val'=>'content1']);
```
tag can be: `td`, `th`, 