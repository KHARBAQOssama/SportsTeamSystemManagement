export function authorize(to, from, next) {
  const user = JSON.parse(localStorage.getItem('currentUser'));

  if (!user) {
    return next('/sign')
  }

  const allowedRoles = to.meta.roles
  const allowedPermissions = to.meta.permissions

  if (!allowedRoles && !allowedPermissions) {
    return next()
  }

  console.log(user);

  const userRole = user.role
  const userPermissions = user.permissions

  if (allowedRoles && !allowedRoles.some(role => role == userRole.name)) {
    console.log('from role')
    return next('/403')
  }

  if (allowedPermissions && !userPermissions.some(permission => allowedPermissions.includes(permission.name))) {
    console.log('permission')
    return next('/403')
  }

  return next()
}