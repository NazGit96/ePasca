<?php

namespace App\Traits;

use App\Models\Capaian;

trait HasPermissionsTrait {

    public function givePermissionsTo(... $permissions) {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function withdrawPermissionsTo( ... $permissions ) {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions( ... $permissions ) {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    public function hasPermissionThroughRole($permission) {
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole( ... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('nama', $role)) {
                return true;
            }
        }
        return false;
    }

    public function roles() {
        return $this->hasOne(RefPeranan::class,'id_peranan');

    }

    public function getPermissions(){
        $user_permissions = Capaian::where('id_pengguna', $this->id)
            ->where('pembeza', 'CapaianPengguna')
            ->get();

        $allowed = $user_permissions->where('dibenarkan', true);
        $forbidden = $user_permissions->where('dibenarkan', false)->pluck('nama');

        $role_permissions = Capaian::where('id_peranan', $this->id_peranan)
            ->where('pembeza', 'CapaianPeranan')
            ->where('dibenarkan', true)
            ->whereNotIn('nama', $forbidden)
            ->orderby('nama')
            ->get();

        return $allowed->merge($role_permissions);
    }

    public function hasPermission($permissions) {
        $exist = false;
        foreach($permissions as $permission){
            if($this->getPermissions()->where('nama', $permission)->count()){
                $exist = true;
                break;
            }
        }

        return $exist;
    }

    protected function getAllPermissions(array $permissions) {
        return Capaian::whereIn('nama',$permissions)->get();

    }

}
