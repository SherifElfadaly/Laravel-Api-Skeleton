<?php
namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reporting\Services\ReportService;

class ApiDocumentController extends Controller
{
    /**
     * @var ReprotService
     */
    protected $reportService;

    /**
     * Init new object.
     *
     * @return  void
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $jsonDoc    = json_decode(file_get_contents(app_path('Modules/Core/Resources/api.json')), true);
        $modules    = $jsonDoc['modules'];
        $reports    = $jsonDoc['reports'];
        $errors     = $jsonDoc['errors'];
        $models     = $jsonDoc['models'];
        $conditions = [
            [
                'title'   => 'email equal John@Doe.com:',
                'content' => ['email' => 'John@Doe.com']
            ],
            [
                'title'   => 'email equal John@Doe.com and user is blocked:',
                'content' => ['and' => ['email' => 'John@Doe.com', 'blocked' => 1]]
            ],
            [
                'title'   => 'email equal John@Doe.com or user is blocked:',
                'content' => ['or' => ['email' => 'John@Doe.com', 'blocked' => 1]]
            ],
            [
                'title'   => 'email contain John:',
                'content' => ['email' => ['op' => 'like', 'val' => '%John%']]
            ],
            [
                'title'   => 'user created after 2016-10-25:',
                'content' => ['created_at' => ['op' => '>', 'val' => '2016-10-25']]
            ],
            [
                'title'   => 'user created between 2016-10-20 and 2016-10-25:',
                'content' => ['created_at' => ['op' => 'between', 'val1' => '2016-10-20', 'val2' => '2016-10-25']]
            ],
            [
                'title'   => 'user id in 1,2,3:',
                'content' => ['id' => ['op' => 'in', 'val' => [1, 2, 3]]]
            ],
            [
                'title'   => 'user name is null:',
                'content' => ['name' => ['op' => 'null']]
            ],
            [
                'title'   => 'user name is not null:',
                'content' => ['name' => ['op' => 'not null']]
            ],
            [
                'title'   => 'user has role admin:',
                'content' => ['roles' => ['op' => 'has', 'val' => ['name' => 'Admin']]]
            ]
        ];

        $paginateObject = [
            'data' => ['Array of model objects'],
            "links" => [
                "first" => "apiUrl?page=1",
                "last" => "apiUrl?page=3",
                "prev" => "apiUrl?page=2",
                "next" => "apiUrl?page=3"
            ],
            "meta" => [
                "current_page" => 2,
                "from" => 6,
                "last_page" => 3,
                "path" => "apiUrl",
                "per_page" => 5,
                "to" => 10,
                "total" => 15
            ]
        ];
        
        $responseObject = [
            'data' => ['The model object']
        ];

        $avaialableReports = $this->reportService->all();

        return view('core::doc', ['modules' => $modules, 'reports' => $reports, 'errors' => $errors, 'conditions' => $conditions, 'models' => $models, 'paginateObject' => json_encode($paginateObject, JSON_PRETTY_PRINT), 'responseObject' => json_encode($responseObject, JSON_PRETTY_PRINT), 'avaialableReports' => $avaialableReports]);
    }
}
