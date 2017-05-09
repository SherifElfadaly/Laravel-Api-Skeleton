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
		$conditions = [
			[
				"title"   => "email equal John@Doe.com:",
				"content" => "{\n  \"email\" =>\"John@Doe.com\"\n}"
			],
			[
				"title"   => "email equal John@Doe.com and user is blocked:",
				"content" => "{\n  \"and\":{\n  \"email\" =>\"John@Doe.com\",\n  \"blocked\" =>1\n  }\n}"
			],
			[
				"title"   => "email equal John@Doe.com or user is blocked:",
				"content" => "{\n  \"or\":{\n  \"email\" =>\"John@Doe.com\",\n  \"blocked\" =>1\n  {\n}"
			],
			[
				"title"   => "email contain John:",
				"content" => "{\n  \"email\" =>{\n  \"op\" =>\"like\",\n  \"val\" =>\"%John%\"\n  }\n}"
			],
			[
				"title"   => "user created after 2016-10-25:",
				"content" => "{\n  \"created_at\" =>{\n  \"op\" =>\">\",\n  \"val\" =>\"2016-10-25\"\n  }\n}"
			],
			[
				"title"   => "user created between 2016-10-20 and 2016-10-25:",
				"content" => "{\n  \"created_at\" =>{\n  \"op\" =>\"between\",\n  \"val1\" =>\"2016-10-20\",\n  \"val2\" =>\"2016-10-25\"\n  {\n}"
			],
			[
				"title"   => "user id in 1,2,3:",
				"content" => "{\n  \"id\" =>{\n  \"op\" =>\"in\",\n  \"val\" =>[1, 2, 3]\n}"
			],
			[
				"title"   => "user name is null:",
				"content" => "{\n  \"name\" =>{\n  \"op\" =>\"null\"\n}"
			],
			[
				"title"   => "user name is not null:",
				"content" => "{\n  \"name\" =>{\n  \"op\" =>\"not null\"\n}"
			],
			[
				"title"   => "user has group admin:",
				"content" => "{\n  \"groups\" =>{\n  \"op\" =>\"has\",\n  \"val\" =>{\n  \t\"name\" =>\"Admin\"\n  }\n}"
			]
		];

		return view('core::doc', ['baseUrl' => $baseUrl, 'modules' => $modules, 'errors' => $errors, 'conditions' => $conditions]);
	}
}
