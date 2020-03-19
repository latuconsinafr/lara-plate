# lara-plate

lara-plate is a laravel boilerplate based on l5-repository which using repositories pattern as an abstraction to the database layer, for further information you might check http://andersao.github.io/l5-repository.

If you want to know a little more about the Repository pattern you might [read this great article](http://bit.ly/1IdmRNS).

## Table of Contents

- <a href="#laravel">Laravel</a>
- <a href="#installation">Installation</a>
- <a href="#authentication">Authentication</a>
- <a href="#methods">Methods</a>
    - <a href="#prettusrepositorycontractsrepositoryinterface">RepositoryInterface</a>
    - <a href="#prettusrepositorycontractsrepositorycriteriainterface">RepositoryCriteriaInterface</a>
    - <a href="#prettusrepositorycontractscacheableinterface">CacheableInterface</a>
    - <a href="#prettusrepositorycontractspresenterinterface">PresenterInterface</a>
    - <a href="#prettusrepositorycontractscriteriainterface">CriteriaInterface</a>
- <a href="#usage">Usage</a>
	- <a href="#use-methods">Use methods</a>
	- <a href="#create-a-criteria">Create a Criteria</a>
	- <a href="#using-the-criteria-in-a-controller">Using the Criteria in a Controller</a>
	- <a href="#using-the-requestcriteria">Using the RequestCriteria</a>
- <a href="#cache">Cache</a>
    - <a href="#cache-usage">Usage</a>
- <a href="#validators">Validators</a>
    - <a href="#using-a-validator-class">Using a Validator Class</a>
        - <a href="#create-a-validator">Create a Validator</a>
        - <a href="#enabling-validator-in-your-repository-1">Enabling Validator in your Repository</a>
    - <a href="#defining-rules-in-the-repository">Defining rules in the repository</a>
- <a href="#presenters">Presenters</a>
    - <a href="#fractal-presenter">Fractal Presenter</a>
        - <a href="#create-a-presenter">Create a Fractal Presenter</a>
        - <a href="#implement-interface">Model Transformable</a>
    - <a href="#enabling-in-your-repository-1">Enabling in your Repository</a>

## Laravel

This repository built on laravel 6.x version. For further information you might read the laravel 6.x documentation https://laravel.com/docs/6.x.

## Installation

You might clone the repository via git clone https://github.com/latuconsinafr/lara-plate.git or download it as a zip. By default there's two entities created "Post" and "User".

## Authentication

This repository currently applied two kind of authentication schemes, api and web authentication. Api authentication built with [Laravel Passport](https://laravel.com/docs/6.x/passport) and the web authentication built using default laravel auth.

## Methods

All the methods here based on l5-repository.

### Prettus\Repository\Contracts\RepositoryInterface

- all($columns = array('*'))
- first($columns = array('*'))
- paginate($limit = null, $columns = ['*'])
- find($id, $columns = ['*'])
- findByField($field, $value, $columns = ['*'])
- findWhere(array $where, $columns = ['*'])
- findWhereIn($field, array $where, $columns = [*])
- findWhereNotIn($field, array $where, $columns = [*])
- findWhereBetween($field, array $where, $columns = [*])
- create(array $attributes)
- update(array $attributes, $id)
- updateOrCreate(array $attributes, array $values = [])
- delete($id)
- deleteWhere(array $where)
- orderBy($column, $direction = 'asc');
- with(array $relations);
- has(string $relation);
- whereHas(string $relation, closure $closure);
- hidden(array $fields);
- visible(array $fields);
- scopeQuery(Closure $scope);
- getFieldsSearchable();
- setPresenter($presenter);
- skipPresenter($status = true);


### Prettus\Repository\Contracts\RepositoryCriteriaInterface

- pushCriteria($criteria)
- popCriteria($criteria)
- getCriteria()
- getByCriteria(CriteriaInterface $criteria)
- skipCriteria($status = true)
- getFieldsSearchable()

### Prettus\Repository\Contracts\CacheableInterface

- setCacheRepository(CacheRepository $repository)
- getCacheRepository()
- getCacheKey($method, $args = null)
- getCacheMinutes()
- skipCache($status = true)

### Prettus\Repository\Contracts\PresenterInterface

- present($data);

### Prettus\Repository\Contracts\Presentable

- setPresenter(PresenterInterface $presenter);
- presenter();

### Prettus\Repository\Contracts\CriteriaInterface

- apply($model, RepositoryInterface $repository);

### Prettus\Repository\Contracts\Transformable

- transform();


## Usage

#### Commands

To generate everything you need for your Model, run this command (for an example you want to create a Book model):

```terminal
php artisan make:entity Book
```

After you run the command above, there will be options. Based on what you choose, the command will create the Controller, the Validator, the Model, the Repository, the Presenter and the Transformer classes.
It will also create a new service provider that will be used to bind the Eloquent Repository with its corresponding Repository Interface.
To load it, just add this to your AppServiceProvider@register method:

```php
    $this->app->register(RepositoryServiceProvider::class);
```

The command will also create your basic RESTfull controller so just add this line into your routes you could place it in `routes.php` file and you will have a basic CRUD:

 ```php
 Route::resource('books', BooksController::class);
 ```

When running the command, you will be creating the "Entities" folder and "Repositories" inside the folder that you set as the default.

Now that is done, you still need to bind its interface for your real repository, for example in your own Repositories Service Provider.

```php
App::bind('\App\Repositories\Contracts\BookRepository', '\App\Repositories\Eloquent\BookRepositoryEloquent');
```

And use

```php
public function __construct(\App\Repositories\Contracts\BookRepository $repository){
    $this->repository = $repository;
}
```

### Use methods

```php
namespace App\Http\Controllers;

use App\BookRepository;

class BookController extends BaseController {

    /**
     * @var BookRepository
     */
    protected $repository;

    public function __construct(BookRepository $repository){
        $this->repository = $repository;
    }

    ....
}
```

Find all results in Repository

```php
$books = $this->repository->all();
```

Find all results in Repository with pagination

```php
$books = $this->repository->paginate($limit = null, $columns = ['*']);
```

Find by result by id

```php
$book = $this->repository->find($id);
```

Hiding attributes of the model

```php
$book = $this->repository->hidden(['title'])->find($id);
```

Showing only specific attributes of the model

```php
$book = $this->repository->visible(['id', 'title'])->find($id);
```

Loading the Model relationships

```php
$book = $this->repository->with(['title'])->find($id);
```

Find by result by field name

```php
$books = $this->repository->findByField('title','Negeri 5 Menara');
```

Find by result by multiple fields

```php
$books = $this->repository->findWhere([
    //Default Condition =
    'Title' => 'Negara',
  
    //Custom Condition
    ['columnName','>','10']
]);
```

Find by result by multiple values in one field

```php
$books = $this->repository->findWhereIn('id', [1,2,3,4,5]);
```

Find by result by excluding multiple values in one field

```php
$books = $this->repository->findWhereNotIn('id', [6,7,8,9,10]);
```

Find all using custom scope

```php
$books = $this->repository->scopeQuery(function($query){
    return $query->orderBy('sort_order','asc');
})->all();
```

Create new entry in Repository

```php
$book = $this->repository->create( Input::all() );
```

Update entry in Repository

```php
$book = $this->repository->update( Input::all(), $id );
```

Delete entry in Repository

```php
$this->repository->delete($id)
```

Delete entry in Repository by multiple fields

```php
$this->repository->deleteWhere([
    //Default Condition =
    'id' => '1',
    'title' => 'Negeri',
])
```

### Create a Criteria

#### Using the command

```terminal
php artisan make:criteria MyCriteria
```

Criteria are a way to change the repository of the query by applying specific conditions according to your needs. You can add multiple Criteria in your repository.

```php

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class MyCriteria implements CriteriaInterface {

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('user_id','=', Auth::user()->id );
        return $model;
    }
}
```

### Using the Criteria in a Controller

```php

namespace App\Http\Controllers;

use App\BookRepository;

class BooksController extends BaseController {

    /**
     * @var BookRepository
     */
    protected $repository;

    public function __construct(BookRepository $repository){
        $this->repository = $repository;
    }


    public function index()
    {
        $this->repository->pushCriteria(new MyCriteria1());
        $this->repository->pushCriteria(MyCriteria2::class);
        $books = $this->repository->all();
		...
    }

}
```

Getting results from Criteria

```php
$books = $this->repository->getByCriteria(new MyCriteria());
```

Setting the default Criteria in Repository

```php
use Prettus\Repository\Eloquent\BaseRepository;

class BookRepository extends BaseRepository {

    public function boot(){
        $this->pushCriteria(new MyCriteria());
        // or
        $this->pushCriteria(AnotherCriteria::class);
        ...
    }

    function model(){
       return "App\\Book";
    }
}
```

### Skip criteria defined in the repository

Use `skipCriteria` before any other chaining method

```php
$books = $this->repository->skipCriteria()->all();
```

### Popping criteria

Use `popCriteria` to remove a criteria

```php
$this->repository->popCriteria(new Criteria1());
// or
$this->repository->popCriteria(Criteria1::class);
```


### Using the RequestCriteria

RequestCriteria is a standard Criteria implementation. It enables filters to perform in the repository from parameters sent in the request.

You can perform a dynamic search, filter the data and customize the queries.

To use the Criteria in your repository, you can add a new criteria in the boot method of your repository, or directly use in your controller, in order to filter out only a few requests.

#### Enabling in your Repository

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


class BookRepository extends BaseRepository {

	/**
     * @var array
     */
    protected $fieldSearchable = [
        'title'
    ];

    public function boot(){
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        ...
    }

    function model(){
       return "App\\Book";
    }
}
```

Remember, you need to define which fields from the model can be searchable.

In your repository set **$fieldSearchable** with the name of the fields to be searchable or a relation to fields.

```php
protected $fieldSearchable = [
	'title',
];
```

You can set the type of condition which will be used to perform the query, the default condition is "**=**"

```php
protected $fieldSearchable = [
	'title'=>'like',
	'author', // Default Condition "="
];
```


#### Enabling in your Controller

```php
	public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $books = $this->repository->all();
		...
    }
```

#### Example the Criteria

Request all data without filter by request (Using User Entity)

`http://prettus.local/users`

```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum",
        "email": "lorem@ipsum.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    },
    {
        "id": 3,
        "name": "Laravel",
        "email": "laravel@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    }
]
```

Conducting research in the repository

`http://prettus.local/users?search=John%20Doe`

or

`http://prettus.local/users?search=John&searchFields=name:like`

or

`http://prettus.local/users?search=john@gmail.com&searchFields=email:=`

or

`http://prettus.local/users?search=name:John Doe;email:john@gmail.com`

or

`http://prettus.local/users?search=name:John;email:john@gmail.com&searchFields=name:like;email:=`

```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@gmail.com",
        "created_at": "-0001-11-30 00:00:00",
        "updated_at": "-0001-11-30 00:00:00"
    }
]
```

By default RequestCriteria makes its queries using the **OR** comparison operator for each query parameter.
`http://prettus.local/users?search=age:17;email:john@gmail.com`

The above example will execute the following query:
``` sql
SELECT * FROM users WHERE age = 17 OR email = 'john@gmail.com';
```

In order for it to query using the **AND**, pass the *searchJoin* parameter as shown below:

`http://prettus.local/users?search=age:17;email:john@gmail.com&searchJoin=and`





Filtering fields

`http://prettus.local/users?filter=id;name`

```json
[
    {
        "id": 1,
        "name": "John Doe"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum"
    },
    {
        "id": 3,
        "name": "Laravel"
    }
]
```

Sorting the results

`http://prettus.local/users?filter=id;name&orderBy=id&sortedBy=desc`

```json
[
    {
        "id": 3,
        "name": "Laravel"
    },
    {
        "id": 2,
        "name": "Lorem Ipsum"
    },
    {
        "id": 1,
        "name": "John Doe"
    }
]
```

Sorting through related tables

`http://prettus.local/users?orderBy=books|title&sortedBy=desc`

Query will have something like this

```sql
...
INNER JOIN books ON users.book_id = books.id
...
ORDER BY title
...
```

`http://prettus.local/users?orderBy=books:custom_id|books.title&sortedBy=desc`

Query will have something like this

```sql
...
INNER JOIN books ON users.custom_id = books.id
...
ORDER BY books.title
...
```


Add relationship

`http://prettus.local/users?with=groups`


### Cache

Add a layer of cache easily to your repository

#### Cache Usage

Implements the interface CacheableInterface and use CacheableRepository Trait.

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class BookRepository extends BaseRepository implements CacheableInterface {

    use CacheableRepository;

    ...
}
```

Done , done that your repository will be cached , and the repository cache is cleared whenever an item is created, modified or deleted.

### Validators

Requires [prettus/laravel-validator](https://github.com/prettus/laravel-validator). `composer require prettus/laravel-validator`

Easy validation with `prettus/laravel-validator`

[For more details click here](https://github.com/prettus/laravel-validator)

#### Using a Validator Class

##### Create a Validator

In the example below, we define some rules for both creation and edition

```php
use \Prettus\Validator\LaravelValidator;

class BookValidator extends LaravelValidator {

    protected $rules = [
        'title' => 'required',
        'author'=> 'required'
    ];

}
```

To define specific rules, proceed as shown below:

```php
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class BookValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => 'required',
            'author'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => 'required'
        ]
   ];

}
```

##### Enabling Validator in your Repository

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class BookRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model(){
       return "App\\Book";
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return "App\\BookValidator";
    }
}
```

#### Defining rules in the repository

Alternatively, instead of using a class to define its validation rules, you can set your rules directly into the rules repository property, it will have the same effect as a Validation class.

```php
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;

class BookRepository extends BaseRepository {

    /**
     * Specify Validator Rules
     * @var array
     */
     protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => 'required',
            'text'  => 'min:3',
            'author'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => 'required'
        ]
   ];

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model(){
       return "App\\Book";
    }

}
```

Validation is now ready. In case of a failure an exception will be given of the type: *Prettus\Validator\Exceptions\ValidatorException*

### Presenters

Presenters function as a wrapper and renderer for objects.

#### Fractal Presenter

Requires [Fractal](http://fractal.thephpleague.com/). `composer require league/fractal`

There are two ways to implement the Presenter, the first is creating a TransformerAbstract and set it using your Presenter class as described in the Create a Transformer Class.

The second way is to make your model implement the Transformable interface, and use the default Presenter ModelFractarPresenter, this will have the same effect.

##### Transformer Class

###### Create a Transformer using the command

```terminal
php artisan make:transformer Book
```

This will generate the class beneath.

###### Create a Transformer Class

```php
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    public function transform(\Book $book)
    {
        return [
            'id'      => (int) $book->id,
            'title'   => $book->title
        ];
    }
}
```

###### Create a Presenter using the command

```terminal
php artisan make:presenter Book
```

The command will prompt you for creating a Transformer too if you haven't already.
###### Create a Presenter

```php
use Prettus\Repository\Presenter\FractalPresenter;

class BookPresenter extends FractalPresenter {

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BookTransformer();
    }
}
```

###### Enabling in your Repository

```php
use Prettus\Repository\Eloquent\BaseRepository;

class BookRepository extends BaseRepository {

    ...

    public function presenter()
    {
        return "App\\Presenter\\BookPresenter";
    }
}
```

Or enable it in your controller with

```php
$this->repository->setPresenter("App\\Presenter\\BookPresenter");
```

###### Using the presenter after from the Model

If you recorded a presenter and sometime used the `skipPresenter()` method or simply you do not want your result is not changed automatically by the presenter.
You can implement Presentable interface on your model so you will be able to present your model at any time. See below:

In your model, implement the interface `Prettus\Repository\Contracts\Presentable` and `Prettus\Repository\Traits\PresentableTrait`

```php
namespace App;

use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Book extends Eloquent implements Presentable {

    use PresentableTrait;

    protected $fillable = [
        'title',
        'author',
        ...
     ];

     ...
}
```

There, now you can submit your Model individually, See an example:

```php
$repository = app('App\BookRepository');
$repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter");

//Getting the result transformed by the presenter directly in the search
$book = $repository->find(1);

print_r( $book ); //It produces an output as array

...

//Skip presenter and bringing the original result of the Model
$book = $repository->skipPresenter()->find(1);

print_r( $book ); //It produces an output as a Model object
print_r( $book->presenter() ); //It produces an output as array

```

You can skip the presenter at every visit and use it on demand directly into the model, for it set the `$skipPresenter` attribute to true in your repository:

```php
use Prettus\Repository\Eloquent\BaseRepository;

class BookRepository extends BaseRepository {

    /**
    * @var bool
    */
    protected $skipPresenter = true;

    public function presenter()
    {
        return "App\\Presenter\\BookPresenter";
    }
}
```

##### Model Class

###### Implement Interface

```php
namespace App;

use Prettus\Repository\Contracts\Transformable;

class Book extends Eloquent implements Transformable {
     ...
     /**
      * @return array
      */
     public function transform()
     {
         return [
             'id'      => (int) $this->id,
             'title'   => $this->title
         ];
     }
}
```

###### Enabling in your Repository

`Prettus\Repository\Presenter\ModelFractalPresenter` is a Presenter default for Models implementing Transformable

```php
use Prettus\Repository\Eloquent\BaseRepository;

class BookRepository extends BaseRepository {

    ...

    public function presenter()
    {
        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
    }
}
```

Or enable it in your controller with

```php
$this->repository->setPresenter("Prettus\\Repository\\Presenter\\ModelFractalPresenter");
```

### Skip Presenter defined in the repository

Use *skipPresenter* before any other chaining method

```php
$books = $this->repository->skipPresenter()->all();
```

or

```php
$this->repository->skipPresenter();

$books = $this->repository->all();
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
