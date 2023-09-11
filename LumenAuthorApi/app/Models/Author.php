<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model {
	use HasFactory;

	protected $table = 'authors';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var string[]
	 */
	protected $fillable = [
		'name', 'gender', 'country',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var string[]
	 */
	protected $hidden = [];
}
