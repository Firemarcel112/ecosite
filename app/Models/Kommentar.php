<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kommentar extends Model
{
	use HasFactory;

	protected $primaryKey = 'aufgaben_kommentar_id';

	protected $table = 'aufgaben_kommentare';

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'author_id');
	}
}
