// Import the Config.json file
import config from '../../../config/pages.json';

// export const paranGuards = (to, from, next) => {
//     document.title = to.meta?.title ?? 'دانشبورد';
//     let token = localStorage.getItem('token');
//     let users = localStorage.getItem('users');
//
//     if (token && users) {
//         let user = JSON.parse(users);
//         let userRole = user.roles[0].name
//         let pathSegments = to.path.split('/');
//
//         let pageData = Config.pages[pathSegments[3]];
//         let dashboard = Config.pages[pathSegments[2]];
//
//
//         if (pageData ) {
//             // Check if the user's role matches the role required for this page
//             if (pageData.role === userRole || pageData.role2 === userRole) {
//                 return next();
//             }
//         }
//         if (dashboard.name === "dashboard"){
//             return next();
//         }
//         return next('/');
//     }
//    return next('/');
// };

export const AuthUser = (to, from, next) => {
  document.title = to.meta?.title ?? 'صفحه اصلی'
  let token = localStorage.getItem('token');
  let users = localStorage.getItem('users');

  if (!token || !users) {
    return next('/'); // یا هر صفحه لاگین
  }
  return next();
};

