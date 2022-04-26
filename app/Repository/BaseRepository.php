<?php

namespace App\Repository;

use App\Entity\User;
use App\Exceptions\ClientException\SearchException;
use App\Service\PaginationService;
use App\Service\Search\Search;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BaseRepository
{
	protected $model;
	protected $paginateService;

	public function __construct($model, $paginate = null)
	{
		$this->model = $model;
		$this->paginateService = $paginate ?: app(PaginationService::class);
	}

	protected function ensureNotNull($input)
	{
		if (is_null($input))
		{
			throw new ModelNotFoundException;
		}
	}

	public function getModel()
	{
		return $this->model;
	}

	public function add($entity)
	{
		$entity->save();
	}

	public function all()
	{
		return $this->model->all();
	}

	/**
	 * Find via user_id
	 */
	public function findByUserId($input)
	{
		return $this->model->where('user_id', $input)->first();
	}

	public function findByUserPrimaryKey($input)
	{
		return $this->model->where('user_id', $input)->first();
	}

	
	/**
	 * Get via user_id
	 */
	public function getById($input)
	{
		return $this->getByPrimaryKey($input);
	}

	public function getByUserPrimaryKey($input)
	{
		$this->ensureNotNull($input);

		$key = User::keyName();

		return $this->model->where($key, '=', $input)->firstOrFail();
	}

	/**
	 * Get via id
	 */
	public function getByPrimaryKey($input)
	{
		$this->ensureNotNull($input);

		$key = $this->model->getKeyName();

		return $this->model->where($key, '=', $input)->firstOrFail();
	}

	/**
	 * Search and paginate result (magic)
	 * 
	 * @return Illuminate\Database\Query\Builder
	 */
	public function getSearchQuery(Request $request = null, $search = null, $paginate = null)
	{
		$request = $request ?: app(Request::class);
		$search  = $search ?: app(Search::class);

		$query   = $search->makeQuery($this->model, $request);
		$query   = $this->paginateService->paginateViaRequest($request, $query);

		return $query;
	}
}
