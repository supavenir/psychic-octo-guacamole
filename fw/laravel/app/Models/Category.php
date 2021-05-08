<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string|null $name
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'category_';
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'idCategory');
	}
}
