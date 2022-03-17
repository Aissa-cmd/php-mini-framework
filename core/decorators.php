<?php

// function login_required($func) {
//   return function($req) use($func) {
//     if(is_null($req->user)) {
//       return redirect('/login');
//     }
//     return $func($req);
//   };
// }

$login_required = function($req, $next) {
  if(is_null($req->user)) {
    return redirect('/login');
  }
  return $next();
};

