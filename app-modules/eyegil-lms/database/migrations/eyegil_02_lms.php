<?php

use Eyegil\Base\Commons\Migration\Migrator;
use Eyegil\EyegilLms\Models\Answer;
use Eyegil\EyegilLms\Models\MultipleChoice;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
	public function up()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Question::class)
			->createSchema(Answer::class)
			->createSchema(MultipleChoice::class)
			->createSchema(QuestionGroup::class)
			->up();
	}

	public function down()
	{
		$migrator = new Migrator();
		$migrator->createSchema(Question::class)
			->createSchema(Answer::class)
			->createSchema(MultipleChoice::class)
			->createSchema(QuestionGroup::class)
			->down();
	}
};
