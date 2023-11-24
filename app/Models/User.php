<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    // ...
    protected $fillable = ['name', 'email', 'password', 'balance'];

    protected $hidden = ['password'];

    /**
     * @return string
     */
    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @param $value
     * @return bool
     */
    public function addBalance($value)
    {
        return $this->update(['balance' => $this->balance + $value]);
    }

    /**
     * @param $value
     * @return bool
     */
    public function subBalance($value)
    {
        return $this->update(['balance' => $this->balance - $value]);
    }
}
