<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/userLogin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ntk6HzTpbUo5VRWA',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/analyticsData' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9953diKzgwvLG1lb',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/dashboardStatus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DE6YZwH4FV7SA2j6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/getProfile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::C3nBYHgxTOBXWM2B',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/capaStatus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jSJoxhBH1fnIDr0U',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v3xNljrDg2CnNZb0',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logincheck' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jS38DaAz52jCRGbn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms_check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vWs731sNhh2IQrvC',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::J0aBZ7OVQi98Hbu3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/error' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'error.route',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::N3FoWzQ0mNnP2Ciw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pNQOoZ7Q2TxYguxF',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgetPassword-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lCP9ziZMVOpM5h0L',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/data-fields' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xlhKC7l6dv6fEkcr',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-control' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-control/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documents' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documents.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'documents.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documents/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documents.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentExportPDF' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentExportPDF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentExportEXCEL' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentExportEXCEL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/import' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'csv.import',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/importpdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zOD52VM02FAvycYh',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/division_submit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division_submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dcrDivision' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'dcrDivision_submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentsContent' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/documentsContent/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sendforstagechanage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UXo6a80DoLpxPo7d',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'get.data',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/send-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nh3fsrYILwShohvA',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ThOF3h3KRCGBSTpx',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/advanceSearch' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::24ArZMRDT5ne5Qfy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mytaskdata' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MPBp7nYehdBL8pGP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mydms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5StG5Zgwf0qlGfiq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1zFuRpAeGZllYgmE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4ffw1lv4T3mBD3qN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/analytics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UCltg51XCDyvJXEc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/subscribe' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XeewmLA8hRKrb5fK',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/TMS' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/TMS/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/question' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'question.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/question/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/question-bank' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/question-bank/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quize' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quize.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'quize.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quize/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quize.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qms-dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kmF0k11Crr9rLNLV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/capa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QbjbE2zJRl2s7izW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/capastore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capastore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/managestore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'managestore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/risk-management' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3GnqOtekSy8o7X23',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/risk_store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'risk_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/root-cause-analysis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OqC0rCXZ2dVkuiFD',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rootstore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'root_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/auditee_store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auditee_store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lab-incident' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JF6Jmgd2SMake9Ld',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/audit-program' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VBdfSzYWthlwYgac',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/emp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kAKgeUFyFwNJbYvz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tasks' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ejzkUjxpe9aUYjrU',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/review-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::psNqarVkH2CQhvjO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/audit-trial-inner' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sXDX14MlP39nTAWa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/new-pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::o5Q8OGANlbTSckRY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/new-login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sTbRQksHmFhRBerl',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/helpdesk-personnel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NjsAPeiI1ArJTxvL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/designate-proxy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8sRPrRZFs2FN2OMv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/person-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vKpy267Lv73DJ4tp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/basic-search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x8rglIwkrKYu9InU',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/create-training' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XOBjhIiyjY6ZiK26',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/example' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6KkhhUlQ0QTvI6Zk',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/create-quiz' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Sxff7nwVEBKVdEEH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/document-view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nnAs7VGMSNUuLcem',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/training-page' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cXcP5BsLk8qealhL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/question-training' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::asVNXvH5kGgDnrJc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/edit-question' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ztF7BkEFiRBi5pNW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-control-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mmiPVZCet3GNhvBz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/auditReport' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KvTITOIWiskAWcUv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-control-list-print' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TAw54JH1FmAnVD50',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-control-view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aYX4wD3b4C1E5lZx',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reviewer-panel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NHsstH4v7Hn0k5Bj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-control-form' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vSeXichQaoOUVCPt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/new-change-control' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lSUQqmivG2SOIpis',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/audit-pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FF17clzC68YDOBFE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VdtMx2ngAhY1HJ3I',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data-releted' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XV1yOoyOrHrIXvaC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data-initialDeviationCategory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5dco66A5XqnHMjYj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data-postCategorizationOfDeviation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D3vSKa1R6wLePmeM',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data-capa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::L548H8Znl3Lnb5Ex',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data-dep' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2eHk2Ewix7mdJ5QK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/chart-data-statuswise' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9TOzpT28qfnQf747',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms_login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AQYKzthhnyZuSdjf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms_dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::b16wUvLOUBwKD95Q',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms_desktop' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IfZdMQx3fHIIb3ON',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard_search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'main_dashboard_search',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms_reports' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::csXdw0ujEJm2SROF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Quality-Dashboard-Report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CQyrH9bEBOzjmn0s',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Supplier-Dashboard-Report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yvd4bSDuxjWY8gPt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/QMSDashboardFormat' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ysPbVmfcABMnEXbN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/deviation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9c2qSwUeef8VcbdK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'customers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/extension_form' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LNhB2pFDKj2c7Hnt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cc-form' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ABIhKyqWTuBKF2yz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/audit-management' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ci9WOB5uqebbHgtA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/out-of-specification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4mywuDT5D2ZuvXpV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/action-item' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pHOvEoCQWy3YMBdJ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/effectiveness-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8QG2SDaou7uPWwMi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quality-event' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QglRqCIyiw0t9V1Q',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vendor-entity' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TZIG6CWZkOhyf8Bd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/deviation_new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BSOmXCRoTaU96OiL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/recurring_commitment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tiF50oaZsT5mSmzi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sanction' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wSJJG0nWehIMeHDv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/monthly_working' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xgZ8UiMzeMQ7iW8E',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/investigation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::czqyYVOJ0SVGXEuC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/environmental_task' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::soTFS2Q31kQwwu62',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ehs_event' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DTyIKqXPc5iq7kNv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/effectiveness' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Em0aOH7dVvPTBrk1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/action_item' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FyQCGj2hcnOplucC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/violation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::enc7bqAy6QhEOnIM',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/subject' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GSYMnIl4yYuzpNbI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/subject_action_item' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BJxL6BWHISKOrXrz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/study' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BGHLRo7coAs7qJbR',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/serious_adverse_event' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::293hzXZpw52Mplps',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/monitoring_visit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PmuXsXuIKNlRCYr6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/investigational_nda_anda' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PUju7QlsfA3OlClA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cta_amendement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fVlWdPHk1hTgvSUm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/country_sub_data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HmSjKdLLIVn5tKer',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/clinical_site' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::B1iHydcEflynqD6M',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/cta_submission' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fZzgiy4uEQJpl8FZ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/masking' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sopxZ0FUoTqAEnwT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/randomization' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::d1f6xdLb5VxuEfxe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/regulatory_quary_managment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZssewRJVNm9nPrer',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/regulatory_notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dQd4wJem8OkFjOv5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/complaint' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YnqSeRfYYBAw1EX7',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-observation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VX7fP8KCVc0ldkCw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/validation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ONmDuwg5SYnmvtJY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/qualityFollowUp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OthblEiKy9sBoWRC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product-recall' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RVUeV8PjHUHKMvit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/field-inquiry' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bORwsTZdcGdjR0wM',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/out_of_calibration' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0axNKgi0kWfQzINz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/incident' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9YfSV9VakgVnTsvt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/auditee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::233XJI3GDT9fz0yw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/meeting' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::30bQtmgaN6rMpPHy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/market-complaint' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IiQ2N680VpfiDBdG',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/classroom-training' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sblVa8qdtMFQxQm2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PiHd0p455T7hXQ52',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/requirement-template' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bGs3apiYzOa43omJ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/scar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jtVoXyfREr9YjKOY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-audit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v3VLVhem36XF6ijC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/contract' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5O6OaDOI64a3UsrC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5tZ2oI3fJZu8pdKp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-initiated-change' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jDKtVrnBV4tFs7bK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-investigation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3nHouFHd9PJKE5Qz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-issue-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::B1enUV9AcIJrJHO1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-audit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1DzMWTr8SFtfzVBe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/audit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::SeCjsaFducN27xP1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-questionnaire' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kfJM0uadEtkHQHie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/substance' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HvQPQiWCX1aepjsz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/supplier-action-item' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AJz5VJxHe26JZmxf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/registration-template' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eILXzuvYrJK3Wkn0',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/project' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kjHGH2q3tAMQzm2w',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/extension' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1bCCU4yoizedM4aB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/observation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EHWlo7pYhIwOQ4kv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/new-root-cause-analysis' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oEqqyDbBFFyph1Ki',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/help-desk-incident' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uq3fAYVPpeVHouBk',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/review-management-report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WFbEGOXySotCz32S',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/OOT_form' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FFSFIAQVHv0NniVn',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rjXwTGVB3NZwaDSB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fJsKShXLLYXftSlg',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7aWryBdfgJFMDv5k',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MgU0yewQuweAsjZU',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/department' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'department.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'department.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/department/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'department.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/document_subtypes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/document_subtypes/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/document_types' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/document_types/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/documentlanguage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/documentlanguage/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/distributionlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/distributionlist/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/GroupPermission' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/GroupPermission/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/division' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'division.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/division/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/process' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'process.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'process.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/process/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'process.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/risk-level' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/risk-level/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/user_management' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/user_management/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/role_groups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/role_groups/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/printcontrol' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/printcontrol/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/downloadcontrol' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/downloadcontrol/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/product' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'product.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/product/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/material' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'material.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'material.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/material/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'material.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/qms-division' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/qms-division/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/qms-process' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/qms-process/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/rcms' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xiEAfKahBSJhGV9X',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/rcms_login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::o4iaN0fheZfd76Wd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/rcms_dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GBxKe4eRqIR0O1vA',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/form-division' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::03jYUI3ZqnVZWPJI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rcms.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/CC' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'CC.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'CC.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/CC/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'CC.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/actionItem' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/actionItem/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/extension' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extension.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'extension.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/extension/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extension.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/qms-dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fOKULbE3I6pze3PS',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/summary_pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TLcF4TjHlUeW04A9',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/audit_trial_pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FAX4MXsMPCjmQofY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/change_control_single_pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::btOyke5SyDHH76eG',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/change_control_family_pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vZlelHe9dypFNaiy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/effectiveness' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/effectiveness/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/helpdesk-personnel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bS5ArPblRuapTU3g',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/send-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::npZcQp6YDOM2QU72',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/new-change-control' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::H2d8BYEyvvh00cEp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/audit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'createInternalAudit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/labcreate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'labIncidentCreate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'createAuditProgram',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/observationstore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'observationstore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/formDivision' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'formDivision',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/deviationstore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviationstore',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/rcms/deviation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7YKpX3ssdvKxf7bL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/r(?|e(?|set\\-password/([^/]++)(*:38)|v(?|ision/([^/]++)(*:63)|\\-details/([^/]++)(*:88))|ject_Risk/([^/]++)(*:114))|iskA(?|ssesment(?|Update/([^/]++)(*:156)|StateChange([^/]++)(*:183))|uditTrial/([^/]++)(*:210))|oot(?|Update/([^/]++)(*:240)|show/([^/]++)(*:261)|/(?|stage/([^/]++)(*:287)|cancel/([^/]++)(*:310)|reject/([^/]++)(*:333))|AuditTrial/([^/]++)(*:361))|cms/(?|CC/([^/]++)(?|(*:391)|/edit(*:404)|(*:412))|a(?|ction(?|Item/([^/]++)(?|(*:449)|/edit(*:462)|(*:470))|\\-(?|stage\\-cancel/([^/]++)(*:506)|item\\-audittrial(?|show/([^/]++)(*:546)|details/([^/]++)(*:570)))|item(?|SingleReport/([^/]++)(*:608)|AuditReport/([^/]++)(*:636)))|udit(?|\\-(?|trial/([^/]++)(*:672)|detail/([^/]++)(*:695))|/([^/]++)(*:713)|DetailsLabIncident/([^/]++)(*:748)|Program(?|Details/([^/]++)(*:782)|SingleReport/([^/]++)(*:811)|AuditReport/([^/]++)(*:839))))|e(?|ffective(?|\\-audit\\-trial\\-(?|show/([^/]++)(*:897)|details/([^/]++)(*:921))|SingleReport/([^/]++)(*:951)|AuditReport/([^/]++)(*:979)|ness(?|/([^/]++)(?|(*:1006)|/edit(*:1020)|(*:1029))|\\-reject/([^/]++)(*:1056)))|xtension(?|_child/([^/]++)(*:1093)|/([^/]++)(?|(*:1114)|/edit(*:1128)|(*:1137))|\\-audit\\-trial(?|/([^/]++)(*:1173)|\\-details/([^/]++)(*:1200))|SingleReport/([^/]++)(*:1231)|AuditReport/([^/]++)(*:1260))|Check/([^/]++)(*:1284))|s(?|end\\-(?|e(?|xtension/([^/]++)(*:1327)|ffectiveness/([^/]++)(*:1357))|reject(?|\\-extention/([^/]++)(*:1396)|ion\\-field/([^/]++)(*:1424))|c(?|ancel(?|\\-extention/([^/]++)(*:1466)|/([^/]++)(*:1484))|ft\\-field/([^/]++)(*:1512)|c/([^/]++)(*:1531))|At/([^/]++)(*:1552))|ummary/([^/]++)(*:1577))|c(?|h(?|ild(?|/([^/]++)(*:1610)|_(?|audit_program/([^/]++)(*:1645)|management_Review/([^/]++)(*:1680)))|ange_control_single_pdf/([^/]++)(*:1723))|cView/([^/]++)/([^/]++)(*:1756)|a(?|ncel/([^/]++)(*:1782)|pa(?|SingleReport/([^/]++)(*:1817)|AuditReport/([^/]++)(*:1846))))|qms\\-dashboard(?|/([^/]++)/([^/]++)(*:1893)|_new/([^/]++)/([^/]++)(*:1924))|internal(?|AuditShow/([^/]++)(*:1963)|SingleReport/([^/]++)(*:1993)|auditReport/([^/]++)(*:2022))|update(?|/([^/]++)(*:2050)|LabIncident/([^/]++)(*:2079))|InternalAudit(?|StateChange/([^/]++)(*:2125)|Trial(?|Show/([^/]++)(*:2155)|Details/([^/]++)(*:2180)))|LabIncident(?|S(?|how/([^/]++)(*:2221)|tateChange/([^/]++)(*:2249)|ingleReport/([^/]++)(*:2278))|C(?|ancel/([^/]++)(*:2306)|hild(?|Capa/([^/]++)(*:2335)|Root/([^/]++)(*:2357)))|Audit(?|Trial/([^/]++)(*:2390)|Report/([^/]++)(*:2414)))|RejectStateChange(?|Esign/([^/]++)(*:2459)|/([^/]++)(*:2477))|r(?|oot(?|_cause_analysis/([^/]++)(*:2521)|SingleReport/([^/]++)(*:2551)|AuditReport/([^/]++)(*:2580))|isk(?|SingleReport/([^/]++)(*:2617)|AuditReport/([^/]++)(*:2646)))|Audit(?|Program(?|Show/([^/]++)(*:2688)|TrialShow/([^/]++)(*:2715)|Cancel/([^/]++)(*:2739))|StateChange/([^/]++)(*:2769)|RejectStateChange/([^/]++)(*:2804))|UpdateAuditProgram/([^/]++)(*:2841)|observation(?|show/([^/]++)(*:2877)|update/([^/]++)(*:2901)|_(?|send_stage/([^/]++)(*:2933)|child/([^/]++)(*:2956)))|boostStage/([^/]++)(*:2986)|ObservationAuditTrial(?|Show/([^/]++)(*:3032)|Details/([^/]++)(*:3057))|ExternalAudit(?|SingleReport/([^/]++)(*:3104)|TrialReport/([^/]++)(*:3133))|managementReview(?|/([^/]++)(*:3171)|Report/([^/]++)(*:3195))|dev(?|show/([^/]++)(*:3224)|iation(?|/(?|stage/([^/]++)(*:3260)|c(?|ancel/([^/]++)(*:3287)|heck(?|/([^/]++)(*:3312)|2/([^/]++)(*:3331)|3/([^/]++)(*:3350)|cft/([^/]++)(*:3371))|ftnotreqired/([^/]++)(*:3402))|reject/([^/]++)(*:3427)|Qa/([^/]++)(*:3447))|update/([^/]++)(*:3472)|SingleReport/([^/]++)(*:3502)|parentchildReport/([^/]++)(*:3537)))))|/c(?|h(?|ange\\-control(?|/([^/]++)(?|(*:3587)|/edit(*:3601)|(*:3610))|\\-audit(?|/([^/]++)(*:3639)|\\-detail/([^/]++)(*:3665)))|ild(?|/([^/]++)(*:3691)|_external/([^/]++)(*:3718)))|apa(?|Update/([^/]++)(*:3750)|show/([^/]++)(*:3772)|/(?|stage/([^/]++)(*:3799)|cancel/([^/]++)(*:3823)|reject/([^/]++)(*:3847)|Qa/([^/]++)(*:3867))|_child/([^/]++)(*:3892)))|/d(?|ivision/change/([^/]++)(*:3931)|oc(?|uments(?|/(?|([^/]++)(?|(*:3969)|/edit(*:3983)|(*:3992))|generatePdf/([^/]++)(*:4022)|reviseCreate/([^/]++)(*:4052)|printPDF/([^/]++)(*:4078)|viewpdf/([^/]++)(*:4103))|Content/([^/]++)(?|(*:4132)|/edit(*:4146)|(*:4155)))|\\-details/([^/]++)(*:4184))|ata(?|/([^/]++)(*:4209)|g/([^/]++)(*:4228))|eviation_child/([^/]++)(*:4261))|/s(?|end\\-(?|notification/([^/]++)(*:4305)|change\\-control/([^/]++)(*:4338))|how/([^/]++)(*:4360))|/notification/([^/]++)(*:4392)|/a(?|udit(?|Print/([^/]++)(*:4427)|\\-(?|trial/([^/]++)(*:4455)|individual/([^/]++)/([^/]++)(*:4492)|detail(?|/([^/]++)(*:4519)|s/([^/]++)(*:4538)))|Details(?|Capa/([^/]++)(*:4572)|risk/([^/]++)(*:4594)|Root/([^/]++)(*:4616)))|dmin/(?|d(?|epartment/([^/]++)(?|(*:4660)|/edit(*:4674)|(*:4683))|o(?|cument(?|_(?|subtypes/([^/]++)(?|(*:4730)|/edit(*:4744)|(*:4753))|types/([^/]++)(?|(*:4780)|/edit(*:4794)|(*:4803)))|language/([^/]++)(?|(*:4834)|/edit(*:4848)|(*:4857)))|wnloadcontrol/([^/]++)(?|(*:4893)|/edit(*:4907)|(*:4916)))|i(?|stributionlist/([^/]++)(?|(*:4957)|/edit(*:4971)|(*:4980))|vision/([^/]++)(?|(*:5008)|/edit(*:5022)|(*:5031))))|GroupPermission/([^/]++)(?|(*:5070)|/edit(*:5084)|(*:5093))|pr(?|o(?|cess/([^/]++)(?|(*:5128)|/edit(*:5142)|(*:5151))|duct/([^/]++)(?|(*:5177)|/edit(*:5191)|(*:5200)))|intcontrol/([^/]++)(?|(*:5233)|/edit(*:5247)|(*:5256)))|r(?|isk\\-level/([^/]++)(?|(*:5293)|/edit(*:5307)|(*:5316))|ole_groups/([^/]++)(?|(*:5348)|/edit(*:5362)|(*:5371)))|user_management/(?|([^/]++)(?|(*:5412)|/edit(*:5426)|(*:5435))|duplicate/([^/]++)(*:5463))|material/([^/]++)(?|(*:5493)|/edit(*:5507)|(*:5516))|qms\\-(?|division/([^/]++)(?|(*:5554)|/edit(*:5568)|(*:5577))|process/([^/]++)(?|(*:5606)|/edit(*:5620)|(*:5629)))))|/update(?|\\-doc/([^/]++)(*:5666)|/([^/]++)(*:5684))|/TMS(?|/([^/]++)(?|(*:5713)|/edit(*:5727)|(*:5736))|\\-details/([^/]++)/([^/]++)(*:5773))|/t(?|raining(?|/([^/]++)(*:5807)|Question/([^/]++)(*:5833)|\\-notification/([^/]++)(*:5865)|Complete/([^/]++)(*:5891))|ms\\-audit(?|/([^/]++)(*:5922)|\\-detail/([^/]++)(*:5948)))|/e(?|xample/([^/]++)(*:5979)|ffectiveness_check/([^/]++)(*:6015))|/qu(?|estion(?|/([^/]++)(?|(*:6052)|/edit(*:6066)|(*:6075))|data/([^/]++)(*:6098)|\\-bank/([^/]++)(?|(*:6125)|/edit(*:6139)|(*:6148)))|ize/([^/]++)(?|(*:6174)|/edit(*:6188)|(*:6197)))|/Ca(?|paAuditTrial/([^/]++)(*:6235)|ncelStateExternalAudit/([^/]++)(*:6275))|/manage(?|Update/([^/]++)(*:6310)|show/([^/]++)(*:6332)|/(?|stage/([^/]++)(*:6359)|cancel/([^/]++)(*:6383)|reject/([^/]++)(*:6407)|Qa/([^/]++)(*:6427)))|/ManagementReviewAudit(?|Trial/([^/]++)(*:6477)|Details/([^/]++)(*:6502))|/R(?|iskManagement/([^/]++)(*:6539)|ejectState(?|Auditee/([^/]++)(*:6577)|Change/([^/]++)(*:6601)))|/internalauditreject/([^/]++)(*:6641)|/InternalAuditC(?|ancel/([^/]++)(*:6682)|hild/([^/]++)(*:6704))|/ExternalAudit(?|StateChange/([^/]++)(*:6751)|Trial(?|Show/([^/]++)(*:6781)|Details/([^/]++)(*:6806)))|/StageChangeLabIncident/([^/]++)(*:6849)|/LabIncidentCancel/([^/]++)(*:6885)|/DeviationAuditTrial(?|/([^/]++)(*:6926)|Details/([^/]++)(*:6951)))/?$}sDu',
    ),
    3 => 
    array (
      38 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NdR7skdsSMrpBnLE',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      63 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eorqq1sHRaaIdZEg',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      88 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5MTJKw156ENXkECa',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      114 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reject_Risk',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      156 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'riskUpdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      183 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'riskAssesmentStateUpdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      210 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4IagY5kaUGMiRwpt',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      240 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'root_update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      261 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'root_show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      287 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'root_send_stage',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      310 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'root_Cancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      333 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'root_reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      361 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FiKramzhtDSsYfDL',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      391 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'CC.show',
          ),
          1 => 
          array (
            0 => 'CC',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      404 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'CC.edit',
          ),
          1 => 
          array (
            0 => 'CC',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      412 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'CC.update',
          ),
          1 => 
          array (
            0 => 'CC',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'CC.destroy',
          ),
          1 => 
          array (
            0 => 'CC',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      449 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.show',
          ),
          1 => 
          array (
            0 => 'actionItem',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      462 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.edit',
          ),
          1 => 
          array (
            0 => 'actionItem',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      470 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.update',
          ),
          1 => 
          array (
            0 => 'actionItem',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'actionItem.destroy',
          ),
          1 => 
          array (
            0 => 'actionItem',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      506 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yrBSiOJM4u6MbDwS',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      546 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showActionItemAuditTrial',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      570 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showaudittrialactionItem',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      608 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionitemSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      636 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'actionitemAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      672 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VPa68XHVp8OyCorY',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      695 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u4nRUvL8zNpXYfN3',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      713 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ugNeVbXxnOxX5Omj',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      748 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LabIncidentauditDetails',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auditProgramAuditTrialDetails',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      811 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auditProgramSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      839 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auditProgramAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      897 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'show_effective_AuditTrial',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      921 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'show_audittrial_effective',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      951 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      979 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1006 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.show',
          ),
          1 => 
          array (
            0 => 'effectiveness',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1020 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.edit',
          ),
          1 => 
          array (
            0 => 'effectiveness',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1029 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.update',
          ),
          1 => 
          array (
            0 => 'effectiveness',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'effectiveness.destroy',
          ),
          1 => 
          array (
            0 => 'effectiveness',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1056 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::o72g2U2Z2rlf39of',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1093 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extension_child',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1114 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extension.show',
          ),
          1 => 
          array (
            0 => 'extension',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1128 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extension.edit',
          ),
          1 => 
          array (
            0 => 'extension',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1137 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extension.update',
          ),
          1 => 
          array (
            0 => 'extension',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'extension.destroy',
          ),
          1 => 
          array (
            0 => 'extension',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1173 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u41N5K5VzoJKLj1W',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1200 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jOFmOig8dKHkx7eN',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1231 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extensionSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1260 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'extensionAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1284 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vVsOo6dzn5jXWdAT',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1327 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9lGHUNtMRrHS7EgK',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1357 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QjwbBpOtJ80p5hRK',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1396 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bHVxHXfmd2Xt2h9g',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1424 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::r74mbGQIJBFsx5Af',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1466 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yR9uFkXjCF4XwT6Z',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1484 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::k4rdq9Hu7EJt1GZA',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1512 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eCu1MVwDjPAfTL7L',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1531 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sS8KQLYMjJioSF9K',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1552 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XPOqI6GKFq43ZH5y',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1577 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bupgf8oqXxVezSgS',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1610 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UzYRSGQa0G170Hxm',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1645 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'auditProgramChild',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1680 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childmanagementReview',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1723 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0wbFjSeBRk6PVGKq',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1756 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ccView',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'moreinfo_effectiveness',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1817 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capaSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1846 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capaAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1893 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Zz30PGwodKaICCvv',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'process',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1924 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6X9gAFfAsmz2NOmP',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'process',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1963 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showInternalAudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1993 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'internalSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2022 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'internalauditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2050 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'updateInternalAudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2079 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LabIncidentUpdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2125 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'AuditStateChange',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2155 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ShowInternalAuditTrial',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2180 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showaudittrialinternalaudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2221 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ShowLabIncident',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2249 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'StageChangeLabIncident',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2278 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LabIncidentSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2306 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LabIncidentCancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2335 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lab_incident_capa_child',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2357 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lab_incident_root_child',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2390 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'audittrialLabincident',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2414 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LabIncidentAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2459 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'RejectStateChange',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2477 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'RejectStateChangeObservation',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2521 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Child_root_cause_analysis',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2551 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rootSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2580 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'rootAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2617 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'riskSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2646 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'riskAuditReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2688 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ShowAuditProgram',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2715 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showAuditProgramTrial',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2739 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'AuditProgramCancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2769 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'StateChangeAuditProgram',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2804 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'AuditProgramStateRecject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2841 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'AuditProgramUpdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2877 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showobservation',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2901 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'observationupdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2933 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'observation_change_stage',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2956 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'observationchild',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2986 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'updatestageobservation',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3032 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ShowObservationAuditTrial',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3057 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showaudittrialobservation',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3104 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ExternalAuditSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3133 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ExternalAuditTrialReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3171 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'managementReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3195 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'managementReviewReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3224 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'devshow',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3260 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviation_send_stage',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3287 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviationCancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3312 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'check',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3331 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'check2',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3350 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'check3',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3371 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'checkcft',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3402 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'cftnotreqired',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3427 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviation_reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3447 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviation_qa_more_info',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3472 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviationupdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3502 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviationSingleReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3537 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviationparentchildReport',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3587 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.show',
          ),
          1 => 
          array (
            0 => 'change_control',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3601 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.edit',
          ),
          1 => 
          array (
            0 => 'change_control',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3610 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.update',
          ),
          1 => 
          array (
            0 => 'change_control',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'change-control.destroy',
          ),
          1 => 
          array (
            0 => 'change_control',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::peFDtTlBQFzqhSni',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3665 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::t16aMWljiA6LEw3V',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3691 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'riskAssesmentChild',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3718 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'childexternalaudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3750 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capaUpdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3772 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capashow',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3799 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capa_send_stage',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3823 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capaCancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3847 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capa_reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3867 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capa_qa_more_info',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3892 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capa_child_changecontrol',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3931 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division_change',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3969 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documents.show',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3983 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documents.edit',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      3992 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documents.update',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'documents.destroy',
          ),
          1 => 
          array (
            0 => 'document',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4022 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ebwlHQDd7pPPhk2l',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4052 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MMiYiUmLX9NNJ6VI',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4078 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Q1Oht2QO7uLJWdIh',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4103 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::r5be9Koab2cJOahh',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4132 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.show',
          ),
          1 => 
          array (
            0 => 'documentsContent',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4146 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.edit',
          ),
          1 => 
          array (
            0 => 'documentsContent',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4155 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.update',
          ),
          1 => 
          array (
            0 => 'documentsContent',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'documentsContent.destroy',
          ),
          1 => 
          array (
            0 => 'documentsContent',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4184 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7A7qppO53itzFQVo',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4209 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'data',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4228 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'datag',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4261 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'deviation_child_1',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4305 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QPshSQBdmJWKK07a',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4338 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::feLUPo1jpTRNZFly',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4360 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showExternalAudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4392 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7riYfZ6Gp9lKvCAY',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4427 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FW3ApWAjNlVCXUIN',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4455 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NQvRskyONDd9Ecl3',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4492 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JrEKS2mjnjHxwAbq',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4519 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'audit-detail',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4538 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'audit-details',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4572 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showCapaAuditDetails',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4594 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showriskAuditDetails',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4616 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showrootAuditDetails',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4660 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'department.show',
          ),
          1 => 
          array (
            0 => 'department',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4674 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'department.edit',
          ),
          1 => 
          array (
            0 => 'department',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4683 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'department.update',
          ),
          1 => 
          array (
            0 => 'department',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'department.destroy',
          ),
          1 => 
          array (
            0 => 'department',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4730 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.show',
          ),
          1 => 
          array (
            0 => 'document_subtype',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.edit',
          ),
          1 => 
          array (
            0 => 'document_subtype',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4753 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.update',
          ),
          1 => 
          array (
            0 => 'document_subtype',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'document_subtypes.destroy',
          ),
          1 => 
          array (
            0 => 'document_subtype',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4780 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.show',
          ),
          1 => 
          array (
            0 => 'document_type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4794 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.edit',
          ),
          1 => 
          array (
            0 => 'document_type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4803 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.update',
          ),
          1 => 
          array (
            0 => 'document_type',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'document_types.destroy',
          ),
          1 => 
          array (
            0 => 'document_type',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4834 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.show',
          ),
          1 => 
          array (
            0 => 'documentlanguage',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4848 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.edit',
          ),
          1 => 
          array (
            0 => 'documentlanguage',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4857 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.update',
          ),
          1 => 
          array (
            0 => 'documentlanguage',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'documentlanguage.destroy',
          ),
          1 => 
          array (
            0 => 'documentlanguage',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4893 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.show',
          ),
          1 => 
          array (
            0 => 'downloadcontrol',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4907 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.edit',
          ),
          1 => 
          array (
            0 => 'downloadcontrol',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4916 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.update',
          ),
          1 => 
          array (
            0 => 'downloadcontrol',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'downloadcontrol.destroy',
          ),
          1 => 
          array (
            0 => 'downloadcontrol',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4957 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.show',
          ),
          1 => 
          array (
            0 => 'distributionlist',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4971 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.edit',
          ),
          1 => 
          array (
            0 => 'distributionlist',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4980 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.update',
          ),
          1 => 
          array (
            0 => 'distributionlist',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'distributionlist.destroy',
          ),
          1 => 
          array (
            0 => 'distributionlist',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5008 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division.show',
          ),
          1 => 
          array (
            0 => 'division',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5022 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division.edit',
          ),
          1 => 
          array (
            0 => 'division',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5031 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'division.update',
          ),
          1 => 
          array (
            0 => 'division',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'division.destroy',
          ),
          1 => 
          array (
            0 => 'division',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5070 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.show',
          ),
          1 => 
          array (
            0 => 'GroupPermission',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5084 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.edit',
          ),
          1 => 
          array (
            0 => 'GroupPermission',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5093 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.update',
          ),
          1 => 
          array (
            0 => 'GroupPermission',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'GroupPermission.destroy',
          ),
          1 => 
          array (
            0 => 'GroupPermission',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5128 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'process.show',
          ),
          1 => 
          array (
            0 => 'process',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5142 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'process.edit',
          ),
          1 => 
          array (
            0 => 'process',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5151 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'process.update',
          ),
          1 => 
          array (
            0 => 'process',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'process.destroy',
          ),
          1 => 
          array (
            0 => 'process',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5177 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.show',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5191 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.edit',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5200 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.update',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'product.destroy',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5233 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.show',
          ),
          1 => 
          array (
            0 => 'printcontrol',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5247 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.edit',
          ),
          1 => 
          array (
            0 => 'printcontrol',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5256 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.update',
          ),
          1 => 
          array (
            0 => 'printcontrol',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'printcontrol.destroy',
          ),
          1 => 
          array (
            0 => 'printcontrol',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5293 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.show',
          ),
          1 => 
          array (
            0 => 'risk_level',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5307 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.edit',
          ),
          1 => 
          array (
            0 => 'risk_level',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5316 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.update',
          ),
          1 => 
          array (
            0 => 'risk_level',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'risk-level.destroy',
          ),
          1 => 
          array (
            0 => 'risk_level',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5348 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.show',
          ),
          1 => 
          array (
            0 => 'role_group',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5362 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.edit',
          ),
          1 => 
          array (
            0 => 'role_group',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5371 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.update',
          ),
          1 => 
          array (
            0 => 'role_group',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'role_groups.destroy',
          ),
          1 => 
          array (
            0 => 'role_group',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5412 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.show',
          ),
          1 => 
          array (
            0 => 'user_management',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5426 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.edit',
          ),
          1 => 
          array (
            0 => 'user_management',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5435 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.update',
          ),
          1 => 
          array (
            0 => 'user_management',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.destroy',
          ),
          1 => 
          array (
            0 => 'user_management',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5463 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user_management.duplicate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5493 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'material.show',
          ),
          1 => 
          array (
            0 => 'material',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5507 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'material.edit',
          ),
          1 => 
          array (
            0 => 'material',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'material.update',
          ),
          1 => 
          array (
            0 => 'material',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'material.destroy',
          ),
          1 => 
          array (
            0 => 'material',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5554 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.show',
          ),
          1 => 
          array (
            0 => 'qms_division',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5568 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.edit',
          ),
          1 => 
          array (
            0 => 'qms_division',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5577 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.update',
          ),
          1 => 
          array (
            0 => 'qms_division',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'qms-division.destroy',
          ),
          1 => 
          array (
            0 => 'qms_division',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5606 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.show',
          ),
          1 => 
          array (
            0 => 'qms_process',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5620 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.edit',
          ),
          1 => 
          array (
            0 => 'qms_process',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5629 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.update',
          ),
          1 => 
          array (
            0 => 'qms_process',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'qms-process.destroy',
          ),
          1 => 
          array (
            0 => 'qms_process',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5666 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'update-doc',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5684 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'updateExternalAudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5713 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.show',
          ),
          1 => 
          array (
            0 => 'TM',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5727 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.edit',
          ),
          1 => 
          array (
            0 => 'TM',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      5736 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.update',
          ),
          1 => 
          array (
            0 => 'TM',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'TMS.destroy',
          ),
          1 => 
          array (
            0 => 'TM',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5773 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YHc27xqc9k6oiP7s',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'sopId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5807 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::z7l1ZMlbsXRd5dIU',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5833 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::djBL4edOFSQqXkuB',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5865 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kJ5hZc5Kxm0t7HGp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5891 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wX3BSrB8u4njP5iS',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5922 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yqFUnrAYhmZoS81d',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5948 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5JtqUQZofFjmdVF5',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      5979 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::UEzfFEoON6nqDPEn',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6015 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'capa_effectiveness_check',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6052 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question.show',
          ),
          1 => 
          array (
            0 => 'question',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6066 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question.edit',
          ),
          1 => 
          array (
            0 => 'question',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6075 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question.update',
          ),
          1 => 
          array (
            0 => 'question',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'question.destroy',
          ),
          1 => 
          array (
            0 => 'question',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6098 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'questiondata',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6125 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.show',
          ),
          1 => 
          array (
            0 => 'question_bank',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6139 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.edit',
          ),
          1 => 
          array (
            0 => 'question_bank',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6148 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.update',
          ),
          1 => 
          array (
            0 => 'question_bank',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'question-bank.destroy',
          ),
          1 => 
          array (
            0 => 'question_bank',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6174 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quize.show',
          ),
          1 => 
          array (
            0 => 'quize',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6188 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quize.edit',
          ),
          1 => 
          array (
            0 => 'quize',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      6197 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quize.update',
          ),
          1 => 
          array (
            0 => 'quize',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'quize.destroy',
          ),
          1 => 
          array (
            0 => 'quize',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6235 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lNP76EKZNP9sTEP7',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6275 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'CancelStateExternalAudit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6310 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manageUpdate',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6332 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manageshow',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6359 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage_send_stage',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6383 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manageCancel',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6407 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage_reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6427 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage_qa_more_info',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6477 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OcPMDwvLBZdDcC4o',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6502 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9SY0AFl6m2c0F5rP',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6539 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showRiskManagement',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6577 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'RejectStateAuditee',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6601 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4FuTtahQJhlAVLgJ',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6641 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::T9MghJdBfuHJ3d91',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6682 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EjkEvGPZ9fkfaSYb',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6704 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'internal_audit_child',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6751 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'externalAuditStateChange',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6781 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ShowexternalAuditTrial',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6806 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ExternalAuditTrialDetailsShow',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6849 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EZ0JrqWSoOXCpPI6',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6885 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wGSSlWhEISZQ7qRi',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6926 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::X39hlYb3XvKYIty2',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      6951 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rYxdIEHXkL4gfa9d',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ntk6HzTpbUo5VRWA' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/userLogin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@loginapi',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@loginapi',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::Ntk6HzTpbUo5VRWA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9953diKzgwvLG1lb' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/analyticsData',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@analyticsData',
        'controller' => 'App\\Http\\Controllers\\DashboardController@analyticsData',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::9953diKzgwvLG1lb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DE6YZwH4FV7SA2j6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/dashboardStatus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ApiController@dashboardStatus',
        'controller' => 'App\\Http\\Controllers\\ApiController@dashboardStatus',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::DE6YZwH4FV7SA2j6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::C3nBYHgxTOBXWM2B' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/getProfile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ApiController@getProfile',
        'controller' => 'App\\Http\\Controllers\\ApiController@getProfile',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::C3nBYHgxTOBXWM2B',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jSJoxhBH1fnIDr0U' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/capaStatus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\ApiController@capaStatus',
        'controller' => 'App\\Http\\Controllers\\ApiController@capaStatus',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::jSJoxhBH1fnIDr0U',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v3xNljrDg2CnNZb0' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@userlogin',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@userlogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::v3xNljrDg2CnNZb0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@userlogin',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@userlogin',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jS38DaAz52jCRGbn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logincheck',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@logincheck',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@logincheck',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::jS38DaAz52jCRGbn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@logout',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vWs731sNhh2IQrvC' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms_check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@rcmscheck',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@rcmscheck',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::vWs731sNhh2IQrvC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'error.route' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'error',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:262:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:44:"function () {
    return \\view(\'error\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005850000000000000000";}";s:4:"hash";s:44:"fH7HFrRDeV3HSJnAUtwlTX3bWr5N4+XcEB2mKsJneEk=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'error.route',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::J0aBZ7OVQi98Hbu3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms_check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::J0aBZ7OVQi98Hbu3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.makePassword',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::N3FoWzQ0mNnP2Ciw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::N3FoWzQ0mNnP2Ciw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forgot-password',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NdR7skdsSMrpBnLE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@resetPage',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@resetPage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::NdR7skdsSMrpBnLE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pNQOoZ7Q2TxYguxF' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@UpdateNewPassword',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@UpdateNewPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::pNQOoZ7Q2TxYguxF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lCP9ziZMVOpM5h0L' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgetPassword-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@forgetPassword',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@forgetPassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::lCP9ziZMVOpM5h0L',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xlhKC7l6dv6fEkcr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'data-fields',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:277:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:59:"function () {
    return \\view(\'frontend.data-fields\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009e60000000000000000";}";s:4:"hash";s:44:"frJT8jkaDkZexeM3O6Hz9muCp7I6WPnfH7PLjpsgtm8=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::xlhKC7l6dv6fEkcr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.index',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@index',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.create',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@create',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-control',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.store',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@store',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control/{change_control}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.show',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@show',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control/{change_control}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.edit',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@edit',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'change-control/{change_control}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.update',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@update',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'change-control.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'change-control/{change_control}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'change-control.destroy',
        'uses' => 'App\\Http\\Controllers\\OpenStageController@destroy',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::peFDtTlBQFzqhSni' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control-audit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\OpenStageController@auditTrial',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@auditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::peFDtTlBQFzqhSni',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::t16aMWljiA6LEw3V' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control-audit-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\OpenStageController@auditDetails',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@auditDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::t16aMWljiA6LEw3V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division_change' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'division/change/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\OpenStageController@division',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@division',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'division_change',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QPshSQBdmJWKK07a' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'send-notification/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\OpenStageController@notification',
        'controller' => 'App\\Http\\Controllers\\OpenStageController@notification',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::QPshSQBdmJWKK07a',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.index',
        'uses' => 'App\\Http\\Controllers\\DocumentController@index',
        'controller' => 'App\\Http\\Controllers\\DocumentController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.create',
        'uses' => 'App\\Http\\Controllers\\DocumentController@create',
        'controller' => 'App\\Http\\Controllers\\DocumentController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'documents',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.store',
        'uses' => 'App\\Http\\Controllers\\DocumentController@store',
        'controller' => 'App\\Http\\Controllers\\DocumentController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/{document}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.show',
        'uses' => 'App\\Http\\Controllers\\DocumentController@show',
        'controller' => 'App\\Http\\Controllers\\DocumentController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/{document}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.edit',
        'uses' => 'App\\Http\\Controllers\\DocumentController@edit',
        'controller' => 'App\\Http\\Controllers\\DocumentController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'documents/{document}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.update',
        'uses' => 'App\\Http\\Controllers\\DocumentController@update',
        'controller' => 'App\\Http\\Controllers\\DocumentController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documents.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'documents/{document}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documents.destroy',
        'uses' => 'App\\Http\\Controllers\\DocumentController@destroy',
        'controller' => 'App\\Http\\Controllers\\DocumentController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eorqq1sHRaaIdZEg' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'revision/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@revision',
        'controller' => 'App\\Http\\Controllers\\DocumentController@revision',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::eorqq1sHRaaIdZEg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentExportPDF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentExportPDF',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@documentExportPDF',
        'controller' => 'App\\Http\\Controllers\\DocumentController@documentExportPDF',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'documentExportPDF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentExportEXCEL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentExportEXCEL',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@documentExportEXCEL',
        'controller' => 'App\\Http\\Controllers\\DocumentController@documentExportEXCEL',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'documentExportEXCEL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'csv.import' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'import',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@import',
        'controller' => 'App\\Http\\Controllers\\DocumentController@import',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'csv.import',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zOD52VM02FAvycYh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'importpdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\ImportController@PDFimport',
        'controller' => 'App\\Http\\Controllers\\ImportController@PDFimport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::zOD52VM02FAvycYh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division_submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'division_submit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@division',
        'controller' => 'App\\Http\\Controllers\\DocumentController@division',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'division_submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'dcrDivision_submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dcrDivision',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@dcrDivision',
        'controller' => 'App\\Http\\Controllers\\DocumentController@dcrDivision',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'dcrDivision_submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ebwlHQDd7pPPhk2l' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/generatePdf/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@createPDF',
        'controller' => 'App\\Http\\Controllers\\DocumentController@createPDF',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ebwlHQDd7pPPhk2l',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MMiYiUmLX9NNJ6VI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/reviseCreate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@revise_create',
        'controller' => 'App\\Http\\Controllers\\DocumentController@revise_create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::MMiYiUmLX9NNJ6VI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Q1Oht2QO7uLJWdIh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/printPDF/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@printPDF',
        'controller' => 'App\\Http\\Controllers\\DocumentController@printPDF',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Q1Oht2QO7uLJWdIh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::r5be9Koab2cJOahh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documents/viewpdf/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentController@viewPdf',
        'controller' => 'App\\Http\\Controllers\\DocumentController@viewPdf',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::r5be9Koab2cJOahh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentsContent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.index',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@index',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentsContent/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.create',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@create',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'documentsContent',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.store',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@store',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentsContent/{documentsContent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.show',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@show',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'documentsContent/{documentsContent}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.edit',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@edit',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'documentsContent/{documentsContent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.update',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@update',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentsContent.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'documentsContent/{documentsContent}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'documentsContent.destroy',
        'uses' => 'App\\Http\\Controllers\\DocumentContentController@destroy',
        'controller' => 'App\\Http\\Controllers\\DocumentContentController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7A7qppO53itzFQVo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'doc-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@viewdetails',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@viewdetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::7A7qppO53itzFQVo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UXo6a80DoLpxPo7d' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'sendforstagechanage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@sendforstagechanage',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@sendforstagechanage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::UXo6a80DoLpxPo7d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7riYfZ6Gp9lKvCAY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'notification/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@notification',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@notification',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::7riYfZ6Gp9lKvCAY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get.data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@getData',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@getData',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'get.data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nh3fsrYILwShohvA' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'send-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@sendNotification',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@sendNotification',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::nh3fsrYILwShohvA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ThOF3h3KRCGBSTpx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@search',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@search',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ThOF3h3KRCGBSTpx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::24ArZMRDT5ne5Qfy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'advanceSearch',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@searchAdvance',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@searchAdvance',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::24ArZMRDT5ne5Qfy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FW3ApWAjNlVCXUIN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auditPrint/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@printAudit',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@printAudit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::FW3ApWAjNlVCXUIN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MPBp7nYehdBL8pGP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mytaskdata',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\MytaskController@index',
        'controller' => 'App\\Http\\Controllers\\MytaskController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::MPBp7nYehdBL8pGP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5StG5Zgwf0qlGfiq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mydms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\CabinateController@index',
        'controller' => 'App\\Http\\Controllers\\CabinateController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5StG5Zgwf0qlGfiq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1zFuRpAeGZllYgmE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\CabinateController@email',
        'controller' => 'App\\Http\\Controllers\\CabinateController@email',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::1zFuRpAeGZllYgmE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5MTJKw156ENXkECa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rev-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\MytaskController@reviewdetails',
        'controller' => 'App\\Http\\Controllers\\MytaskController@reviewdetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5MTJKw156ENXkECa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::feLUPo1jpTRNZFly' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'send-change-control/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\ChangeControlController@statechange',
        'controller' => 'App\\Http\\Controllers\\ChangeControlController@statechange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::feLUPo1jpTRNZFly',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NQvRskyONDd9Ecl3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-trial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@auditTrial',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@auditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::NQvRskyONDd9Ecl3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JrEKS2mjnjHxwAbq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-individual/{id}/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@auditTrialIndividual',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@auditTrialIndividual',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::JrEKS2mjnjHxwAbq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'audit-detail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@auditDetails',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@auditDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'audit-detail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'update-doc' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update-doc/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@updatereviewers',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@updatereviewers',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'update-doc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'audit-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DocumentDetailsController@getAuditDetail',
        'controller' => 'App\\Http\\Controllers\\DocumentDetailsController@getAuditDetail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'audit-details',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4ffw1lv4T3mBD3qN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::4ffw1lv4T3mBD3qN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UCltg51XCDyvJXEc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'analytics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@analytics',
        'controller' => 'App\\Http\\Controllers\\DashboardController@analytics',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::UCltg51XCDyvJXEc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XeewmLA8hRKrb5fK' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'subscribe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\DashboardController@subscribe',
        'controller' => 'App\\Http\\Controllers\\DashboardController@subscribe',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::XeewmLA8hRKrb5fK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'TMS',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.index',
        'uses' => 'App\\Http\\Controllers\\TMSController@index',
        'controller' => 'App\\Http\\Controllers\\TMSController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'TMS/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.create',
        'uses' => 'App\\Http\\Controllers\\TMSController@create',
        'controller' => 'App\\Http\\Controllers\\TMSController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'TMS',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.store',
        'uses' => 'App\\Http\\Controllers\\TMSController@store',
        'controller' => 'App\\Http\\Controllers\\TMSController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'TMS/{TM}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.show',
        'uses' => 'App\\Http\\Controllers\\TMSController@show',
        'controller' => 'App\\Http\\Controllers\\TMSController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'TMS/{TM}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.edit',
        'uses' => 'App\\Http\\Controllers\\TMSController@edit',
        'controller' => 'App\\Http\\Controllers\\TMSController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'TMS/{TM}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.update',
        'uses' => 'App\\Http\\Controllers\\TMSController@update',
        'controller' => 'App\\Http\\Controllers\\TMSController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'TMS.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'TMS/{TM}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'TMS.destroy',
        'uses' => 'App\\Http\\Controllers\\TMSController@destroy',
        'controller' => 'App\\Http\\Controllers\\TMSController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YHc27xqc9k6oiP7s' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'TMS-details/{id}/{sopId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@viewTraining',
        'controller' => 'App\\Http\\Controllers\\TMSController@viewTraining',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::YHc27xqc9k6oiP7s',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::z7l1ZMlbsXRd5dIU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'training/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@training',
        'controller' => 'App\\Http\\Controllers\\TMSController@training',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::z7l1ZMlbsXRd5dIU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::djBL4edOFSQqXkuB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'trainingQuestion/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@trainingQuestion',
        'controller' => 'App\\Http\\Controllers\\TMSController@trainingQuestion',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::djBL4edOFSQqXkuB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kJ5hZc5Kxm0t7HGp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'training-notification/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@notification',
        'controller' => 'App\\Http\\Controllers\\TMSController@notification',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kJ5hZc5Kxm0t7HGp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wX3BSrB8u4njP5iS' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'trainingComplete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@trainingStatus',
        'controller' => 'App\\Http\\Controllers\\TMSController@trainingStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::wX3BSrB8u4njP5iS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yqFUnrAYhmZoS81d' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tms-audit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@auditTrial',
        'controller' => 'App\\Http\\Controllers\\TMSController@auditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::yqFUnrAYhmZoS81d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5JtqUQZofFjmdVF5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tms-audit-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@auditDetails',
        'controller' => 'App\\Http\\Controllers\\TMSController@auditDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5JtqUQZofFjmdVF5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UEzfFEoON6nqDPEn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'example/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\TMSController@example',
        'controller' => 'App\\Http\\Controllers\\TMSController@example',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::UEzfFEoON6nqDPEn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.index',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@index',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.create',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@create',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'question',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.store',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@store',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question/{question}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.show',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@show',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question/{question}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.edit',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@edit',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'question/{question}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.update',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@update',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'question/{question}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question.destroy',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionController@destroy',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'questiondata' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'questiondata/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@datag',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@datag',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'questiondata',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question-bank',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.index',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@index',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question-bank/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.create',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@create',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'question-bank',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.store',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@store',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question-bank/{question_bank}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.show',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@show',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question-bank/{question_bank}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.edit',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@edit',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'question-bank/{question_bank}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.update',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@update',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'question-bank.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'question-bank/{question_bank}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'question-bank.destroy',
        'uses' => 'App\\Http\\Controllers\\tms\\QuestionBankController@destroy',
        'controller' => 'App\\Http\\Controllers\\tms\\QuestionBankController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quize',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.index',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@index',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quize/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.create',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@create',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quize',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.store',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@store',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quize/{quize}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.show',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@show',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quize/{quize}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.edit',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@edit',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'quize/{quize}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.update',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@update',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quize.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'quize/{quize}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'as' => 'quize.destroy',
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@destroy',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'data/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@datag',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@datag',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'datag' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'datag/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\tms\\QuizeController@data',
        'controller' => 'App\\Http\\Controllers\\tms\\QuizeController@data',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'datag',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kmF0k11Crr9rLNLV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qms-dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'prevent-back-history',
          3 => 'user-activity',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RcmsDashboardController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\RcmsDashboardController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kmF0k11Crr9rLNLV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QbjbE2zJRl2s7izW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'capa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::QbjbE2zJRl2s7izW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.capa',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capastore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capastore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capastore',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capastore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capastore',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capaUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capaUpdate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capaUpdate',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capaUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capaUpdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capashow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'capashow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capashow',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capashow',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capashow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capa_send_stage' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capa/stage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capa_send_stage',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capa_send_stage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capa_send_stage',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capaCancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capa/cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capaCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capaCancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capaCancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capa_reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capa/reject/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capa_reject',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capa_reject',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capa_reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capa_qa_more_info' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capa/Qa/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@capa_qa_more_info',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@capa_qa_more_info',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capa_qa_more_info',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lNP76EKZNP9sTEP7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'CapaAuditTrial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@CapaAuditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@CapaAuditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::lNP76EKZNP9sTEP7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showCapaAuditDetails' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auditDetailsCapa/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@auditDetailsCapa',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@auditDetailsCapa',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'showCapaAuditDetails',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capa_child_changecontrol' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'capa_child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@child_change_control',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@child_change_control',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capa_child_changecontrol',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capa_effectiveness_check' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'effectiveness_check/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@effectiveness_check',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@effectiveness_check',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'capa_effectiveness_check',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'managestore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'managestore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@managestore',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@managestore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'managestore',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manageUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manageUpdate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manageUpdate',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manageUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'manageUpdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manageshow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'manageshow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manageshow',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manageshow',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'manageshow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage_send_stage' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/stage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manage_send_stage',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manage_send_stage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'manage_send_stage',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manageCancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manageCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manageCancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'manageCancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage_reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/reject/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manage_reject',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manage_reject',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'manage_reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage_qa_more_info' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'manage/Qa/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manage_qa_more_info',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@manage_qa_more_info',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'manage_qa_more_info',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OcPMDwvLBZdDcC4o' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ManagementReviewAuditTrial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@ManagementReviewAuditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@ManagementReviewAuditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::OcPMDwvLBZdDcC4o',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9SY0AFl6m2c0F5rP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ManagementReviewAuditDetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@ManagementReviewAuditDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@ManagementReviewAuditDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::9SY0AFl6m2c0F5rP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3GnqOtekSy8o7X23' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'risk-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@risk',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@risk',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::3GnqOtekSy8o7X23',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showRiskManagement' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'RiskManagement/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@show',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'showRiskManagement',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'risk_store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@store',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'risk_store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'riskUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'riskAssesmentUpdate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@riskUpdate',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@riskUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'riskUpdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'riskAssesmentStateUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'riskAssesmentStateChange{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@riskAssesmentStateChange',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@riskAssesmentStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'riskAssesmentStateUpdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reject_Risk' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reject_Risk/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@RejectStateChange',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@RejectStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reject_Risk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4IagY5kaUGMiRwpt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'riskAuditTrial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@riskAuditTrial',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@riskAuditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::4IagY5kaUGMiRwpt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showriskAuditDetails' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auditDetailsrisk/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@auditDetailsrisk',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@auditDetailsrisk',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'showriskAuditDetails',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'riskAssesmentChild' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@child',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@child',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'riskAssesmentChild',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OqC0rCXZ2dVkuiFD' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'root-cause-analysis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@rootcause',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@rootcause',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::OqC0rCXZ2dVkuiFD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'root_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rootstore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_store',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'root_store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'root_update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rootUpdate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_update',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'root_update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'root_show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rootshow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_show',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'root_show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'root_send_stage' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'root/stage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_send_stage',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_send_stage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'root_send_stage',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'root_Cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'root/cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_Cancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_Cancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'root_Cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'root_reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'root/reject/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_reject',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@root_reject',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'root_reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FiKramzhtDSsYfDL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rootAuditTrial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@rootAuditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@rootAuditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::FiKramzhtDSsYfDL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showrootAuditDetails' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auditDetailsRoot/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@auditDetailsroot',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@auditDetailsroot',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'showrootAuditDetails',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::T9MghJdBfuHJ3d91' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'internalauditreject/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@RejectStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@RejectStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::T9MghJdBfuHJ3d91',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EjkEvGPZ9fkfaSYb' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'InternalAuditCancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditCancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::EjkEvGPZ9fkfaSYb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'internal_audit_child' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'InternalAuditChild/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@internal_audit_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@internal_audit_child',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'internal_audit_child',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showExternalAudit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'show/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@show',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'showExternalAudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auditee_store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'auditee_store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'auditee_store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'updateExternalAudit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'updateExternalAudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'externalAuditStateChange' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ExternalAuditStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@ExternalAuditStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@ExternalAuditStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'externalAuditStateChange',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'RejectStateAuditee' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'RejectStateAuditee/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@RejectStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@RejectStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'RejectStateAuditee',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CancelStateExternalAudit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'CancelStateExternalAudit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@externalAuditCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@externalAuditCancel',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'CancelStateExternalAudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ShowexternalAuditTrial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ExternalAuditTrialShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@AuditTrialExternalShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@AuditTrialExternalShow',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ShowexternalAuditTrial',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ExternalAuditTrialDetailsShow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ExternalAuditTrialDetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@AuditTrialExternalDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@AuditTrialExternalDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ExternalAuditTrialDetailsShow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childexternalaudit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'child_external/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@child_external',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@child_external',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'childexternalaudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JF6Jmgd2SMake9Ld' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lab-incident',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@labincident',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@labincident',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::JF6Jmgd2SMake9Ld',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4FuTtahQJhlAVLgJ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'RejectStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@RejectStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@RejectStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::4FuTtahQJhlAVLgJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EZ0JrqWSoOXCpPI6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'StageChangeLabIncident/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentStateChange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::EZ0JrqWSoOXCpPI6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wGSSlWhEISZQ7qRi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'LabIncidentCancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentCancelStage',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentCancelStage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::wGSSlWhEISZQ7qRi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VBdfSzYWthlwYgac' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-program',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@auditprogram',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@auditprogram',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::VBdfSzYWthlwYgac',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kAKgeUFyFwNJbYvz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'emp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kAKgeUFyFwNJbYvz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'emp',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ejzkUjxpe9aUYjrU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tasks',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ejzkUjxpe9aUYjrU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.T',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::psNqarVkH2CQhvjO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'review-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::psNqarVkH2CQhvjO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.documents.review-details',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sXDX14MlP39nTAWa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-trial-inner',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::sXDX14MlP39nTAWa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.documents.audit-trial-inner',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::o5Q8OGANlbTSckRY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'new-pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::o5Q8OGANlbTSckRY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.documents.new-pdf',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sTbRQksHmFhRBerl' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'new-login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::sTbRQksHmFhRBerl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new-login',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NjsAPeiI1ArJTxvL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'helpdesk-personnel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::NjsAPeiI1ArJTxvL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.helpdesk-personnel',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8sRPrRZFs2FN2OMv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'designate-proxy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::8sRPrRZFs2FN2OMv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.designate-proxy',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vKpy267Lv73DJ4tp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'person-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::vKpy267Lv73DJ4tp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.person-details',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x8rglIwkrKYu9InU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'basic-search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::x8rglIwkrKYu9InU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.basic-search',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XOBjhIiyjY6ZiK26' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'create-training',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::XOBjhIiyjY6ZiK26',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.create-training',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6KkhhUlQ0QTvI6Zk' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'example',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::6KkhhUlQ0QTvI6Zk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.example',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Sxff7nwVEBKVdEEH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'create-quiz',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Sxff7nwVEBKVdEEH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.create-quiz',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nnAs7VGMSNUuLcem' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'document-view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::nnAs7VGMSNUuLcem',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.document-view',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cXcP5BsLk8qealhL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'training-page',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::cXcP5BsLk8qealhL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.training-page',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::asVNXvH5kGgDnrJc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'question-training',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::asVNXvH5kGgDnrJc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.question-training',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ztF7BkEFiRBi5pNW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'edit-question',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ztF7BkEFiRBi5pNW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.TMS.edit-question',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mmiPVZCet3GNhvBz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::mmiPVZCet3GNhvBz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.change-control-list',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KvTITOIWiskAWcUv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auditReport',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::KvTITOIWiskAWcUv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.deviation_report.auditReport',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TAw54JH1FmAnVD50' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control-list-print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::TAw54JH1FmAnVD50',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.change-control-list-print',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aYX4wD3b4C1E5lZx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control-view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::aYX4wD3b4C1E5lZx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.change-control-view',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NHsstH4v7Hn0k5Bj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reviewer-panel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::NHsstH4v7Hn0k5Bj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.reviewer-panel',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vSeXichQaoOUVCPt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'change-control-form',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::vSeXichQaoOUVCPt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.data-fields',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lSUQqmivG2SOIpis' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'new-change-control',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@changecontrol',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@changecontrol',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::lSUQqmivG2SOIpis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FF17clzC68YDOBFE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::FF17clzC68YDOBFE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.documents.audit-pdf',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VdtMx2ngAhY1HJ3I' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartData',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartData',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::VdtMx2ngAhY1HJ3I',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XV1yOoyOrHrIXvaC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data-releted',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataDepartmentReleted',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataDepartmentReleted',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::XV1yOoyOrHrIXvaC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5dco66A5XqnHMjYj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data-initialDeviationCategory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataInitialDeviationCategory',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataInitialDeviationCategory',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5dco66A5XqnHMjYj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D3vSKa1R6wLePmeM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data-postCategorizationOfDeviation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataPostCategorizationOfDeviation',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataPostCategorizationOfDeviation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::D3vSKa1R6wLePmeM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::L548H8Znl3Lnb5Ex' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data-capa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataCapa',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataCapa',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::L548H8Znl3Lnb5Ex',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2eHk2Ewix7mdJ5QK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data-dep',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataDepartment',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fetchChartDataDepartment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::2eHk2Ewix7mdJ5QK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9TOzpT28qfnQf747' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'chart-data-statuswise',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@fatchStatuswise',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@fatchStatuswise',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::9TOzpT28qfnQf747',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AQYKzthhnyZuSdjf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms_login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::AQYKzthhnyZuSdjf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.login',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::b16wUvLOUBwKD95Q' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms_dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::b16wUvLOUBwKD95Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.dashboard',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IfZdMQx3fHIIb3ON' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms_desktop',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@rcms_desktop',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@rcms_desktop',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::IfZdMQx3fHIIb3ON',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'main_dashboard_search' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dashboard_search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DesktopController@main_dashboard_search',
        'controller' => 'App\\Http\\Controllers\\rcms\\DesktopController@main_dashboard_search',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'main_dashboard_search',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::csXdw0ujEJm2SROF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms_reports',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::csXdw0ujEJm2SROF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.reports',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CQyrH9bEBOzjmn0s' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Quality-Dashboard-Report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::CQyrH9bEBOzjmn0s',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.Quality-Dashboard',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yvd4bSDuxjWY8gPt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Supplier-Dashboard-Report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::yvd4bSDuxjWY8gPt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.Supplier-Dashboard',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ysPbVmfcABMnEXbN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'QMSDashboardFormat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ysPbVmfcABMnEXbN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.QMSDashboardFormat',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9c2qSwUeef8VcbdK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'deviation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::9c2qSwUeef8VcbdK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviation_child_1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'deviation_child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_child_1',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_child_1',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'deviation_child_1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::X39hlYb3XvKYIty2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'DeviationAuditTrial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@DeviationAuditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@DeviationAuditTrial',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::X39hlYb3XvKYIty2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rYxdIEHXkL4gfa9d' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'DeviationAuditTrialDetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@DeviationAuditTrialDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@DeviationAuditTrialDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::rYxdIEHXkL4gfa9d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CustomerController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\CustomerController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CustomerController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\CustomerController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LNhB2pFDKj2c7Hnt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'extension_form',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::LNhB2pFDKj2c7Hnt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.extension',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ABIhKyqWTuBKF2yz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cc-form',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ABIhKyqWTuBKF2yz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.change-control',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ci9WOB5uqebbHgtA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit-management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Ci9WOB5uqebbHgtA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.audit-management',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4mywuDT5D2ZuvXpV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'out-of-specification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::4mywuDT5D2ZuvXpV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.out-of-specification',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pHOvEoCQWy3YMBdJ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'action-item',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::pHOvEoCQWy3YMBdJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.action-item',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8QG2SDaou7uPWwMi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'effectiveness-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@effectiveness_check',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@effectiveness_check',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::8QG2SDaou7uPWwMi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QglRqCIyiw0t9V1Q' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quality-event',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::QglRqCIyiw0t9V1Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.quality-event',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TZIG6CWZkOhyf8Bd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vendor-entity',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::TZIG6CWZkOhyf8Bd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.vendor-entity',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BSOmXCRoTaU96OiL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'deviation_new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::BSOmXCRoTaU96OiL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.deviation_new',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tiF50oaZsT5mSmzi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'recurring_commitment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::tiF50oaZsT5mSmzi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.recurring_commitment',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wSJJG0nWehIMeHDv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanction',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::wSJJG0nWehIMeHDv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.sanction',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xgZ8UiMzeMQ7iW8E' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'monthly_working',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::xgZ8UiMzeMQ7iW8E',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.monthly_working',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::czqyYVOJ0SVGXEuC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'investigation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::czqyYVOJ0SVGXEuC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.investigation',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::soTFS2Q31kQwwu62' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'environmental_task',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::soTFS2Q31kQwwu62',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.environmental_task',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DTyIKqXPc5iq7kNv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ehs_event',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::DTyIKqXPc5iq7kNv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.ehs_event',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Em0aOH7dVvPTBrk1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'effectiveness',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Em0aOH7dVvPTBrk1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.effectiveness',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FyQCGj2hcnOplucC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'action_item',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::FyQCGj2hcnOplucC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ehs.action_item',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::enc7bqAy6QhEOnIM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'violation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::enc7bqAy6QhEOnIM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.violation',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GSYMnIl4yYuzpNbI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'subject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::GSYMnIl4yYuzpNbI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.subject',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BJxL6BWHISKOrXrz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'subject_action_item',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::BJxL6BWHISKOrXrz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.subject_action_item',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BGHLRo7coAs7qJbR' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'study',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::BGHLRo7coAs7qJbR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.study',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::293hzXZpw52Mplps' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'serious_adverse_event',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::293hzXZpw52Mplps',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.serious_adverse_event',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PmuXsXuIKNlRCYr6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'monitoring_visit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::PmuXsXuIKNlRCYr6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.monitoring_visit',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PUju7QlsfA3OlClA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'investigational_nda_anda',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::PUju7QlsfA3OlClA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.investigational_nda_anda',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fVlWdPHk1hTgvSUm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cta_amendement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::fVlWdPHk1hTgvSUm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.cta_amendement',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HmSjKdLLIVn5tKer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'country_sub_data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::HmSjKdLLIVn5tKer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.country_sub_data',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::B1iHydcEflynqD6M' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'clinical_site',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::B1iHydcEflynqD6M',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.clinical_site',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fZzgiy4uEQJpl8FZ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cta_submission',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::fZzgiy4uEQJpl8FZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.cta_submission',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sopxZ0FUoTqAEnwT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'masking',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::sopxZ0FUoTqAEnwT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.masking',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::d1f6xdLb5VxuEfxe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'randomization',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::d1f6xdLb5VxuEfxe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.randomization',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZssewRJVNm9nPrer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'regulatory_quary_managment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZssewRJVNm9nPrer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.regulatory_quary_managment',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dQd4wJem8OkFjOv5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'regulatory_notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::dQd4wJem8OkFjOv5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.ctms.regulatory_notification',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YnqSeRfYYBAw1EX7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'complaint',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::YnqSeRfYYBAw1EX7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new_forms.complaint',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VX7fP8KCVc0ldkCw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-observation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::VX7fP8KCVc0ldkCw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new_forms.supplier-observation',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ONmDuwg5SYnmvtJY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'validation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ONmDuwg5SYnmvtJY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new_forms.validation',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OthblEiKy9sBoWRC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'qualityFollowUp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::OthblEiKy9sBoWRC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new_forms.qualityFollowUp',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RVUeV8PjHUHKMvit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product-recall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::RVUeV8PjHUHKMvit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new_forms.product-recall',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bORwsTZdcGdjR0wM' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'field-inquiry',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::bORwsTZdcGdjR0wM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.new_forms.field-inquiry',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0axNKgi0kWfQzINz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'out_of_calibration',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::0axNKgi0kWfQzINz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.OOC.out_of_calibration',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9YfSV9VakgVnTsvt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'incident',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::9YfSV9VakgVnTsvt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.Incident.incident',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::233XJI3GDT9fz0yw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auditee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@external_audit',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@external_audit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::233XJI3GDT9fz0yw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::30bQtmgaN6rMpPHy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'meeting',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@meeting',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@meeting',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::30bQtmgaN6rMpPHy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IiQ2N680VpfiDBdG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'market-complaint',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::IiQ2N680VpfiDBdG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.market-complaint',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sblVa8qdtMFQxQm2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'classroom-training',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::sblVa8qdtMFQxQm2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.classroom-training',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PiHd0p455T7hXQ52' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::PiHd0p455T7hXQ52',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.employee',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bGs3apiYzOa43omJ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'requirement-template',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::bGs3apiYzOa43omJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.requirement-template',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jtVoXyfREr9YjKOY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'scar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::jtVoXyfREr9YjKOY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.scar',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v3VLVhem36XF6ijC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'external-audit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::v3VLVhem36XF6ijC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.external-audit',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5O6OaDOI64a3UsrC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'contract',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5O6OaDOI64a3UsrC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.contract',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5tZ2oI3fJZu8pdKp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::5tZ2oI3fJZu8pdKp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jDKtVrnBV4tFs7bK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-initiated-change',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::jDKtVrnBV4tFs7bK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier-initiated-change',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3nHouFHd9PJKE5Qz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-investigation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::3nHouFHd9PJKE5Qz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier-investigation',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::B1enUV9AcIJrJHO1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-issue-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::B1enUV9AcIJrJHO1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier-issue-notification',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1DzMWTr8SFtfzVBe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-audit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::1DzMWTr8SFtfzVBe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier-audit',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::SeCjsaFducN27xP1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'audit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@internal_audit',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@internal_audit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::SeCjsaFducN27xP1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kfJM0uadEtkHQHie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-questionnaire',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kfJM0uadEtkHQHie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier-questionnaire',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HvQPQiWCX1aepjsz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'substance',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::HvQPQiWCX1aepjsz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.substance',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AJz5VJxHe26JZmxf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'supplier-action-item',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::AJz5VJxHe26JZmxf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.supplier-action-item',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eILXzuvYrJK3Wkn0' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'registration-template',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::eILXzuvYrJK3Wkn0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.registration-template',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kjHGH2q3tAMQzm2w' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'project',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kjHGH2q3tAMQzm2w',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.project',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1bCCU4yoizedM4aB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'extension',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extension_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extension_child',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::1bCCU4yoizedM4aB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EHWlo7pYhIwOQ4kv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'observation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@observation',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@observation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::EHWlo7pYhIwOQ4kv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oEqqyDbBFFyph1Ki' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'new-root-cause-analysis',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::oEqqyDbBFFyph1Ki',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.new-root-cause-analysis',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uq3fAYVPpeVHouBk' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'help-desk-incident',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::uq3fAYVPpeVHouBk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.help-desk-incident',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WFbEGOXySotCz32S' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'review-management-report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::WFbEGOXySotCz32S',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.review-management.review-management-report',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FFSFIAQVHv0NniVn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'OOT_form',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::FFSFIAQVHv0NniVn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.OOT.OOT_form',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rjXwTGVB3NZwaDSB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::rjXwTGVB3NZwaDSB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'admin.auth.login',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fJsKShXLLYXftSlg' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\admin\\LoginController@login',
        'controller' => 'App\\Http\\Controllers\\admin\\LoginController@login',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::fJsKShXLLYXftSlg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7aWryBdfgJFMDv5k' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\admin\\LoginController@logout',
        'controller' => 'App\\Http\\Controllers\\admin\\LoginController@logout',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::7aWryBdfgJFMDv5k',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MgU0yewQuweAsjZU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\admin\\DashboardController@dashboard',
        'controller' => 'App\\Http\\Controllers\\admin\\DashboardController@dashboard',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::MgU0yewQuweAsjZU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/department',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/department/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/department',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/department/{department}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/department/{department}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/department/{department}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'department.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/department/{department}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'department.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DepartmentController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DepartmentController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_subtypes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_subtypes/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/document_subtypes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_subtypes/{document_subtype}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_subtypes/{document_subtype}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/document_subtypes/{document_subtype}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_subtypes.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/document_subtypes/{document_subtype}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_subtypes.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DocSubtypeController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_types',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_types/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/document_types',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_types/{document_type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/document_types/{document_type}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/document_types/{document_type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'document_types.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/document_types/{document_type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'document_types.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentTypeController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/documentlanguage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/documentlanguage/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/documentlanguage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/documentlanguage/{documentlanguage}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/documentlanguage/{documentlanguage}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/documentlanguage/{documentlanguage}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'documentlanguage.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/documentlanguage/{documentlanguage}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'documentlanguage.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DocumentlanguageController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/distributionlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/distributionlist/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/distributionlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/distributionlist/{distributionlist}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/distributionlist/{distributionlist}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/distributionlist/{distributionlist}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'distributionlist.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/distributionlist/{distributionlist}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'distributionlist.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DistributionListController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DistributionListController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/GroupPermission',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.index',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/GroupPermission/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.create',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/GroupPermission',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.store',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/GroupPermission/{GroupPermission}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.show',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/GroupPermission/{GroupPermission}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/GroupPermission/{GroupPermission}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.update',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'GroupPermission.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/GroupPermission/{GroupPermission}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'GroupPermission.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\GroupPermissionController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/division',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/division/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/division',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/division/{division}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/division/{division}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/division/{division}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'division.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/division/{division}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'division.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DivisionController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DivisionController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/process',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.index',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/process/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.create',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/process',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.store',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/process/{process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.show',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/process/{process}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/process/{process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.update',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'process.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/process/{process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'process.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\ProcessController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\ProcessController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/risk-level',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.index',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/risk-level/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.create',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/risk-level',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.store',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/risk-level/{risk_level}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.show',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/risk-level/{risk_level}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/risk-level/{risk_level}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.update',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'risk-level.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/risk-level/{risk_level}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'risk-level.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\RiskLevelController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\RiskLevelController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/user_management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.index',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/user_management/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.create',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/user_management',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.store',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/user_management/{user_management}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.show',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/user_management/{user_management}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/user_management/{user_management}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.update',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/user_management/{user_management}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'user_management.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/role_groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.index',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/role_groups/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.create',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/role_groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.store',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/role_groups/{role_group}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.show',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/role_groups/{role_group}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/role_groups/{role_group}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.update',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role_groups.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/role_groups/{role_group}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'role_groups.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\RoleGroupController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\RoleGroupController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/printcontrol',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.index',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/printcontrol/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.create',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/printcontrol',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.store',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/printcontrol/{printcontrol}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.show',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/printcontrol/{printcontrol}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/printcontrol/{printcontrol}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.update',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'printcontrol.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/printcontrol/{printcontrol}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'printcontrol.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\PrintControlController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\PrintControlController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/downloadcontrol',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.index',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/downloadcontrol/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.create',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/downloadcontrol',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.store',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/downloadcontrol/{downloadcontrol}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.show',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/downloadcontrol/{downloadcontrol}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/downloadcontrol/{downloadcontrol}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.update',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'downloadcontrol.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/downloadcontrol/{downloadcontrol}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'downloadcontrol.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\DownloadControlController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\DownloadControlController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.index',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/product/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.create',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/product',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.store',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/product/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.show',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/product/{product}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/product/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.update',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/product/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'product.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\ProductController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\ProductController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/material',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.index',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/material/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.create',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/material',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.store',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/material/{material}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.show',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/material/{material}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/material/{material}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.update',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'material.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/material/{material}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'material.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\MaterialController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\MaterialController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-division',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.index',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-division/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.create',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/qms-division',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.store',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-division/{qms_division}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.show',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-division/{qms_division}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/qms-division/{qms_division}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.update',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-division.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/qms-division/{qms_division}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-division.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSDivisionController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-process',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.index',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@index',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-process/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.create',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@create',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/qms-process',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.store',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@store',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-process/{qms_process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.show',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@show',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/qms-process/{qms_process}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.edit',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@edit',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'admin/qms-process/{qms_process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.update',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@update',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'qms-process.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/qms-process/{qms_process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'as' => 'qms-process.destroy',
        'uses' => 'App\\Http\\Controllers\\admin\\QMSProcessController@destroy',
        'controller' => 'App\\Http\\Controllers\\admin\\QMSProcessController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'user_management.duplicate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/user_management/duplicate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'admin',
        ),
        'uses' => 'App\\Http\\Controllers\\admin\\UserManagementController@DuplicateShow',
        'controller' => 'App\\Http\\Controllers\\admin\\UserManagementController@DuplicateShow',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'user_management.duplicate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xiEAfKahBSJhGV9X' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/rcms',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::xiEAfKahBSJhGV9X',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.main-screen',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::o4iaN0fheZfd76Wd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/rcms_login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@userlogin',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@userlogin',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::o4iaN0fheZfd76Wd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GBxKe4eRqIR0O1vA' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/rcms_dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::GBxKe4eRqIR0O1vA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.dashboard',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::03jYUI3ZqnVZWPJI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/form-division',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::03jYUI3ZqnVZWPJI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.forms.form-division',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'rcms.logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserLoginController@rcmslogout',
        'controller' => 'App\\Http\\Controllers\\UserLoginController@rcmslogout',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'rcms.logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/CC',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.index',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@index',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/CC/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.create',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/CC',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.store',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@store',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/CC/{CC}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.show',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@show',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@show',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/CC/{CC}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.edit',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@edit',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@edit',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'rcms/CC/{CC}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.update',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@update',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'CC.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'rcms/CC/{CC}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'CC.destroy',
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@destroy',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@destroy',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/actionItem',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.index',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@index',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/actionItem/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.create',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/actionItem',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.store',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@store',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/actionItem/{actionItem}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.show',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@show',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@show',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/actionItem/{actionItem}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.edit',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@edit',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@edit',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'rcms/actionItem/{actionItem}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.update',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@update',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionItem.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'rcms/actionItem/{actionItem}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'actionItem.destroy',
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@destroy',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@destroy',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yrBSiOJM4u6MbDwS' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/action-stage-cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@actionStageCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@actionStageCancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::yrBSiOJM4u6MbDwS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showActionItemAuditTrial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/action-item-audittrialshow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@actionItemAuditTrialShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@actionItemAuditTrialShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showActionItemAuditTrial',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showaudittrialactionItem' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/action-item-audittrialdetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@actionItemAuditTrialDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@actionItemAuditTrialDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showaudittrialactionItem',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionitemSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/actionitemSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'actionitemSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'actionitemAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/actionitemAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'actionitemAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'show_effective_AuditTrial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effective-audit-trial-show/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@effectiveAuditTrialShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@effectiveAuditTrialShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'show_effective_AuditTrial',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'show_audittrial_effective' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effective-audit-trial-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@effectiveAuditTrialDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@effectiveAuditTrialDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'show_audittrial_effective',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effectiveSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'effectiveSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effectiveAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'effectiveAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension_child' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/extension_child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extension_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extension_child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'extension_child',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extension',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.index',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@index',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extension/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.create',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/extension',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.store',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@store',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extension/{extension}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.show',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@show',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@show',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extension/{extension}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.edit',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@edit',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@edit',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'rcms/extension/{extension}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.update',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@update',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extension.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'rcms/extension/{extension}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'extension.destroy',
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@destroy',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@destroy',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9lGHUNtMRrHS7EgK' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-extension/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@stageChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@stageChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::9lGHUNtMRrHS7EgK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bHVxHXfmd2Xt2h9g' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-reject-extention/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@stagereject',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@stagereject',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::bHVxHXfmd2Xt2h9g',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yR9uFkXjCF4XwT6Z' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-cancel-extention/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@stagecancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@stagecancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::yR9uFkXjCF4XwT6Z',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u41N5K5VzoJKLj1W' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extension-audit-trial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extensionAuditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extensionAuditTrial',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::u41N5K5VzoJKLj1W',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jOFmOig8dKHkx7eN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extension-audit-trial-details/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extensionAuditTrialDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@extensionAuditTrialDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::jOFmOig8dKHkx7eN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extensionSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extensionSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'extensionSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'extensionAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/extensionAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ExtensionController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\ExtensionController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'extensionAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XPOqI6GKFq43ZH5y' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-At/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ActionItemController@stageChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\ActionItemController@stageChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::XPOqI6GKFq43ZH5y',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::r74mbGQIJBFsx5Af' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-rejection-field/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@stagereject',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@stagereject',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::r74mbGQIJBFsx5Af',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eCu1MVwDjPAfTL7L' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-cft-field/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@stageCFTnotReq',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@stageCFTnotReq',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::eCu1MVwDjPAfTL7L',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::k4rdq9Hu7EJt1GZA' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@stagecancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@stagecancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::k4rdq9Hu7EJt1GZA',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sS8KQLYMjJioSF9K' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-cc/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@stageChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@stageChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::sS8KQLYMjJioSF9K',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::UzYRSGQa0G170Hxm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@child',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::UzYRSGQa0G170Hxm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fOKULbE3I6pze3PS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/qms-dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::fOKULbE3I6pze3PS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Zz30PGwodKaICCvv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/qms-dashboard/{id}/{process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DashboardController@dashboard_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\DashboardController@dashboard_child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::Zz30PGwodKaICCvv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6X9gAFfAsmz2NOmP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/qms-dashboard_new/{id}/{process}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DashboardController@dashboard_child_new',
        'controller' => 'App\\Http\\Controllers\\rcms\\DashboardController@dashboard_child_new',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::6X9gAFfAsmz2NOmP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VPa68XHVp8OyCorY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/audit-trial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@auditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@auditTrial',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::VPa68XHVp8OyCorY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u4nRUvL8zNpXYfN3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/audit-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@auditDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@auditDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::u4nRUvL8zNpXYfN3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bupgf8oqXxVezSgS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/summary/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@summery_pdf',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@summery_pdf',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::bupgf8oqXxVezSgS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ugNeVbXxnOxX5Omj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/audit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@audit_pdf',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@audit_pdf',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::ugNeVbXxnOxX5Omj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ccView' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/ccView/{id}/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DashboardController@ccView',
        'controller' => 'App\\Http\\Controllers\\rcms\\DashboardController@ccView',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ccView',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TLcF4TjHlUeW04A9' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/summary_pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::TLcF4TjHlUeW04A9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.summary_pdf',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FAX4MXsMPCjmQofY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/audit_trial_pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::FAX4MXsMPCjmQofY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.audit_trial_pdf',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::btOyke5SyDHH76eG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/change_control_single_pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::btOyke5SyDHH76eG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.change-control.change_control_single_pdf',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vZlelHe9dypFNaiy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/change_control_family_pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@parent_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@parent_child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::vZlelHe9dypFNaiy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0wbFjSeBRk6PVGKq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/change_control_single_pdf/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@single_pdf',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@single_pdf',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::0wbFjSeBRk6PVGKq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vVsOo6dzn5jXWdAT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/eCheck/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@eCheck',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@eCheck',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::vVsOo6dzn5jXWdAT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effectiveness',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.index',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@index',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@index',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effectiveness/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.create',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/effectiveness',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.store',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@store',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effectiveness/{effectiveness}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.show',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@show',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@show',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/effectiveness/{effectiveness}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.edit',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@edit',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@edit',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'rcms/effectiveness/{effectiveness}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.update',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@update',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'effectiveness.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'rcms/effectiveness/{effectiveness}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'as' => 'effectiveness.destroy',
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@destroy',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@destroy',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QjwbBpOtJ80p5hRK' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/send-effectiveness/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@stageChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@stageChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::QjwbBpOtJ80p5hRK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::o72g2U2Z2rlf39of' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/effectiveness-reject/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@reject',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@reject',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::o72g2U2Z2rlf39of',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'moreinfo_effectiveness' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@cancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\EffectivenessCheckController@cancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'moreinfo_effectiveness',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bS5ArPblRuapTU3g' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/helpdesk-personnel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::bS5ArPblRuapTU3g',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.helpdesk-personnel',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::npZcQp6YDOM2QU72' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/send-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::npZcQp6YDOM2QU72',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'frontend.rcms.send-notification',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::H2d8BYEyvvh00cEp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/new-change-control',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CCController@changecontrol',
        'controller' => 'App\\Http\\Controllers\\rcms\\CCController@changecontrol',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::H2d8BYEyvvh00cEp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'createInternalAudit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/audit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'createInternalAudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showInternalAudit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/internalAuditShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@internalAuditShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@internalAuditShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showInternalAudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'updateInternalAudit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@update',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'updateInternalAudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'AuditStateChange' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/InternalAuditStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditStateChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'AuditStateChange',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ShowInternalAuditTrial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/InternalAuditTrialShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditTrialShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditTrialShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ShowInternalAuditTrial',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showaudittrialinternalaudit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/InternalAuditTrialDetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditTrialDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@InternalAuditTrialDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showaudittrialinternalaudit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'labIncidentCreate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/labcreate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'labIncidentCreate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ShowLabIncident' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/LabIncidentShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ShowLabIncident',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'StageChangeLabIncident' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/LabIncidentStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentStateChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'StageChangeLabIncident',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'RejectStateChange' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/RejectStateChangeEsign/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@RejectStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@RejectStateChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'RejectStateChange',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LabIncidentUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/updateLabIncident/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@updateLabIncident',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@updateLabIncident',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'LabIncidentUpdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LabIncidentCancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/LabIncidentCancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentCancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'LabIncidentCancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lab_incident_capa_child' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/LabIncidentChildCapa/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@lab_incident_capa_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@lab_incident_capa_child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'lab_incident_capa_child',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lab_incident_root_child' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/LabIncidentChildRoot/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@lab_incident_root_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@lab_incident_root_child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'lab_incident_root_child',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'audittrialLabincident' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/LabIncidentAuditTrial/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentAuditTrial',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@LabIncidentAuditTrial',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'audittrialLabincident',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LabIncidentauditDetails' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/auditDetailsLabIncident/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@auditDetailsLabIncident',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@auditDetailsLabIncident',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'LabIncidentauditDetails',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Child_root_cause_analysis' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/root_cause_analysis/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@root_cause_analysis',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@root_cause_analysis',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'Child_root_cause_analysis',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LabIncidentSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/LabIncidentSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'LabIncidentSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LabIncidentAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/LabIncidentAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\LabIncidentController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'LabIncidentAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'createAuditProgram' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@create',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@create',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'createAuditProgram',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ShowAuditProgram' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/AuditProgramShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditProgramShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditProgramShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ShowAuditProgram',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'StateChangeAuditProgram' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/AuditStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditStateChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'StateChangeAuditProgram',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'AuditProgramStateRecject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/AuditRejectStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditRejectStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditRejectStateChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'AuditProgramStateRecject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'AuditProgramUpdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/UpdateAuditProgram/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@UpdateAuditProgram',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@UpdateAuditProgram',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'AuditProgramUpdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showAuditProgramTrial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/AuditProgramTrialShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditProgramTrialShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditProgramTrialShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showAuditProgramTrial',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auditProgramAuditTrialDetails' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/auditProgramDetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@auditProgramDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@auditProgramDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'auditProgramAuditTrialDetails',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auditProgramChild' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/child_audit_program/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@child_audit_program',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@child_audit_program',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'auditProgramChild',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'AuditProgramCancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/AuditProgramCancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditProgramCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@AuditProgramCancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'AuditProgramCancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auditProgramSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/auditProgramSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'auditProgramSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'auditProgramAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/auditProgramAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditProgramController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'auditProgramAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showobservation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/observationshow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@observationshow',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@observationshow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showobservation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'observationstore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/observationstore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@observationstore',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@observationstore',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'observationstore',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'observationupdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/observationupdate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@observationupdate',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@observationupdate',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'observationupdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'observation_change_stage' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/observation_send_stage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@observation_send_stage',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@observation_send_stage',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'observation_change_stage',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'RejectStateChangeObservation' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/RejectStateChange/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@RejectStateChange',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@RejectStateChange',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'RejectStateChangeObservation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'observationchild' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/observation_child/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@observation_child',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@observation_child',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'observationchild',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'updatestageobservation' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/boostStage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@boostStage',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@boostStage',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'updatestageobservation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ShowObservationAuditTrial' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/ObservationAuditTrialShow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@ObservationAuditTrialShow',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@ObservationAuditTrialShow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ShowObservationAuditTrial',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showaudittrialobservation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/ObservationAuditTrialDetails/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ObservationController@ObservationAuditTrialDetails',
        'controller' => 'App\\Http\\Controllers\\rcms\\ObservationController@ObservationAuditTrialDetails',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'showaudittrialobservation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'formDivision' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/formDivision',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\FormDivisionController@formDivision',
        'controller' => 'App\\Http\\Controllers\\rcms\\FormDivisionController@formDivision',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'formDivision',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ExternalAuditSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/ExternalAuditSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ExternalAuditSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ExternalAuditTrialReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/ExternalAuditTrialReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\AuditeeController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\AuditeeController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'ExternalAuditTrialReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capaSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/capaSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'capaSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'capaAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/capaAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\CapaController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\CapaController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'capaAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'riskSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/riskSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@singleReport',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'riskSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'riskAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/riskAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\RiskManagementController@auditReport',
        'controller' => 'App\\Http\\Controllers\\RiskManagementController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'riskAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'rootSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/rootSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'rootSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'rootAuditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/rootAuditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\RootCauseController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\RootCauseController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'rootAuditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'managementReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/managementReview/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@managementReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@managementReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'managementReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'managementReviewReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/managementReviewReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@managementReviewReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@managementReviewReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'managementReviewReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'childmanagementReview' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/child_management_Review/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@child_management_Review',
        'controller' => 'App\\Http\\Controllers\\rcms\\ManagementReviewController@child_management_Review',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'childmanagementReview',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'internalSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/internalSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'internalSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'internalauditReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/internalauditReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\InternalauditController@auditReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\InternalauditController@auditReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'internalauditReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'devshow' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/devshow/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@devshow',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@devshow',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'devshow',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviation_send_stage' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/stage/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_send_stage',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_send_stage',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviation_send_stage',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviationCancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/cancel/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviationCancel',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviationCancel',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviationCancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviation_reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/reject/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_reject',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_reject',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviation_reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'check' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/check/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@check',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@check',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'check',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'check2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/check2/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@check2',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@check2',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'check2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'check3' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/check3/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@check3',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@check3',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'check3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'cftnotreqired' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/cftnotreqired/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@cftnotreqired',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@cftnotreqired',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'cftnotreqired',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'checkcft' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/checkcft/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@checkcft',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@checkcft',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'checkcft',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviation_qa_more_info' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviation/Qa/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_qa_more_info',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation_qa_more_info',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviation_qa_more_info',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviationstore' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviationstore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@store',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@store',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviationstore',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviationupdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'rcms/deviationupdate/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@update',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@update',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviationupdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7YKpX3ssdvKxf7bL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/deviation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@deviation',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'generated::7YKpX3ssdvKxf7bL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviationSingleReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/deviationSingleReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@singleReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@singleReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviationSingleReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'deviationparentchildReport' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'rcms/deviationparentchildReport/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'rcms',
        ),
        'uses' => 'App\\Http\\Controllers\\rcms\\DeviationController@parentchildReport',
        'controller' => 'App\\Http\\Controllers\\rcms\\DeviationController@parentchildReport',
        'namespace' => NULL,
        'prefix' => '/rcms',
        'where' => 
        array (
        ),
        'as' => 'deviationparentchildReport',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
