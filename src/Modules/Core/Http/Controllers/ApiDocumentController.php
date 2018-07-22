<?php
namespace App\Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocumentController extends Controller
{
	public function index() 
	{
		$baseUrl    = str_replace('public/', '', url('app/Modules/Core'));
		$jsonDoc    = json_decode(file_get_contents(app_path('Modules/Core/Resources/api.json')), true);
		$modules    = $jsonDoc['modules'];
		$errors     = $jsonDoc['errors'];
		$models     = $jsonDoc['models'];
		$conditions = [
			[
				'title'   => 'email equal John@Doe.com:',
				'content' => ['email' => 'John@Doe.com']
			],
			[
				'title'   => 'email equal John@Doe.com and user is blocked:',
				'content' => ['and' => ['email' => 'John@Doe.com','blocked' => 1]]
			],
			[
				'title'   => 'email equal John@Doe.com or user is blocked:',
				'content' => ['or' => ['email' => 'John@Doe.com','blocked' => 1]]
			],
			[
				'title'   => 'email contain John:',
				'content' => ['email' => ['op' => 'like','val' => '%John%']]
			],
			[
				'title'   => 'user created after 2016-10-25:',
				'content' => ['created_at' => ['op' => '>','val' => '2016-10-25']]
			],
			[
				'title'   => 'user created between 2016-10-20 and 2016-10-25:',
				'content' => ['created_at' => ['op' => 'between','val1' => '2016-10-20','val2' => '2016-10-25']]
			],
			[
				'title'   => 'user id in 1,2,3:',
				'content' => ['id' => ['op' => 'in','val' => [1, 2, 3]]]
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
				'title'   => 'user has group admin:',
				'content' => ['groups' => ['op' => 'has','val' => ['name' => 'Admin']]]
			]
		];

		$paginateObject = [
			'total'         => 50,
			'per_page'      => 15,
			'current_page'  => 1,
			'last_page'     => 4,
			'next_page_url' => 'apiUrl?page=2',
			'prev_page_url' => null,
			'from'          => 1,
			'to'            => 15,
			'data'          => ['The model object']
		];

		$avaialableReports = \Core::reports()->all();

		return view('core::doc', ['baseUrl' => $baseUrl, 'modules' => $modules, 'errors' => $errors, 'conditions' => $conditions, 'models' => $models, 'paginateObject' => json_encode($paginateObject, JSON_PRETTY_PRINT), 'avaialableReports' => $avaialableReports]);
	}
}
