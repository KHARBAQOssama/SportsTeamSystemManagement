export function can(permission) {
    const user = JSON.parse(localStorage.getItem('currentUser'));
    const userPermissions = user.permissions
  
    return (userPermissions && userPermissions.some(perm => perm.name == permission));
}