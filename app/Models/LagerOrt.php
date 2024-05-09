<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LagerOrt extends Model
{
	use HasFactory,
		SoftDeletes;

	protected $primaryKey = 'lagerort_id';

	protected $table = 'lagerorte';
}
