<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $firstname
 * @property string|null $lastname
 * @property int|null $age
 * @property string|null $sexe
 * @property string|null $city
 * @property int|null $idCategory
 * 
 * @property Category|null $category
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'user_';
	public $timestamps = false;

	protected $casts = [
		'age' => 'int',
		'idCategory' => 'int'
	];

	protected $fillable = [
		'firstname',
		'lastname',
		'age',
		'sexe',
		'city',
		'idCategory'
	];

	public function category()
	{
		return $this->belongsTo(Category::class, 'idCategory');
	}
}
