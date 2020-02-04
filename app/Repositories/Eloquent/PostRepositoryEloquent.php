<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepository;
use App\Validators\PostValidator;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository, CacheableInterface
{
    use CacheableRepository;

    /**
     * Specify the searchable attribute
     *
     * @var array
     */
    protected $fieldSearchable = [
        'title' => 'like',
        'author' => 'like',
        'content' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return PostValidator::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return mixed
     */
    public function presenter()
    {
        return "App\\Presenters\\PostPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
