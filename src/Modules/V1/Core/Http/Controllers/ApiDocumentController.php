<?php
namespace App\Modules\V1\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocumentController extends Controller
{
	public function index() 
	{
		$path       = str_replace($_SERVER['DOCUMENT_ROOT'], '',str_replace('\\', '/', __FILE__));
		$baseUrl    = str_replace('Http/Controllers/ApiDocumentController.php', '', $path);
		$jsonDoc    = json_decode(file_get_contents(app_path('Modules/V1/Core/Resources/api.json')), true);
		$modules    = $jsonDoc['modules'];
		$errors     = $jsonDoc['errors'];
		$models     = $jsonDoc['models'];
		$conditions = [
			[
				'title'   => 'email equal John@Doe.com:',
				'content' => '{\n  \'email\' =>\'John@Doe.com\'\n}'
			],
			[
				'title'   => 'email equal John@Doe.com and user is blocked:',
				'content' => '{\n  \'and\':{\n  \'email\' =>\'John@Doe.com\',\n  \'blocked\' =>1\n  }\n}'
			],
			[
				'title'   => 'email equal John@Doe.com or user is blocked:',
				'content' => '{\n  \'or\':{\n  \'email\' =>\'John@Doe.com\',\n  \'blocked\' =>1\n  {\n}'
			],
			[
				'title'   => 'email contain John:',
				'content' => '{\n  \'email\' =>{\n  \'op\' =>\'like\',\n  \'val\' =>\'%John%\'\n  }\n}'
			],
			[
				'title'   => 'user created after 2016-10-25:',
				'content' => '{\n  \'created_at\' =>{\n  \'op\' =>\'>\',\n  \'val\' =>\'2016-10-25\'\n  }\n}'
			],
			[
				'title'   => 'user created between 2016-10-20 and 2016-10-25:',
				'content' => '{\n  \'created_at\' =>{\n  \'op\' =>\'between\',\n  \'val1\' =>\'2016-10-20\',\n  \'val2\' =>\'2016-10-25\'\n  {\n}'
			],
			[
				'title'   => 'user id in 1,2,3:',
				'content' => '{\n  \'id\' =>{\n  \'op\' =>\'in\',\n  \'val\' =>[1, 2, 3]\n}'
			],
			[
				'title'   => 'user name is null:',
				'content' => '{\n  \'name\' =>{\n  \'op\' =>\'null\'\n}'
			],
			[
				'title'   => 'user name is not null:',
				'content' => '{\n  \'name\' =>{\n  \'op\' =>\'not null\'\n}'
			],
			[
				'title'   => 'user has group admin:',
				'content' => '{\n  \'groups\' =>{\n  \'op\' =>\'has\',\n  \'val\' =>{\n  \t\'name\' =>\'Admin\'\n  }\n}'
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

		return view('core::doc', ['baseUrl' => $baseUrl, 'modules' => $modules, 'errors' => $errors, 'conditions' => $conditions, 'models' => $models, 'paginateObject' => json_encode($paginateObject, JSON_PRETTY_PRINT)]);
	}
}
