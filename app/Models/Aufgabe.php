<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aufgabe extends Model
{
	use HasFactory;

	protected $primaryKey = 'aufgaben_id';

	protected $table = 'aufgaben';

	public function getReadableStatus()
	{
		switch($this->status)
		{
			case 0:
				return "<span class='text-info'>Offen</span>";
			case 1:
				return "<span class='text-warning'>In Arbeit</span>";
			case 2:
				return "<span class='text-success'>Erledigt</span>";
			default:
			return 'unknown';
		}
	}

	public function getReadablePrioritaet()
	{
		switch($this->priorisierung)
		{
			case 0:
				return 'Am Niedrigsten';
			case 1:
				return 'Niedrig';
			case 2:
				return 'Neutral';
			case 3:
				return "<span class='text-primary'>Hoch</span>";
			case 4:
				return "<span class='text-primary'><b>Sehr Hoch</b></span>";
			default:
			return 'unknown';
		}
	}

	public function scopeIsStatus(Builder $query, int $status)
	{
		return $query->where('status', $status);
	}

	public function scopeIsOffen(Builder $query)
	{
		return $query->where('status', 0);
	}

	public function scopeIsInArbeit(Builder $query)
	{
		return $query->where('status', 1);
	}

	public function scopeIsErledigt(Builder $query)
	{
		return $query->where('status', 2);
	}


	public function author()
	{
		return $this->hasOne(User::class, 'id', 'author_id');
	}

	public function zugewiesen()
	{
		return $this->hasOne(User::class, 'id', 'zugewiesen_id');
	}

	public function kommentare()
	{
		return $this->hasMany(Kommentar::class, 'aufgaben_id', 'aufgaben_id');
	}
}
