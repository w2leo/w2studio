<?php

try {
	require '/home/ec2-user/vendor/autoload.php';
} catch (Error $e) {
	require_once '/Users/mikhailleonov/vendor/autoload.php';
}
require_once('AwsDynamoDB.php');

use Aws\DynamoDb\DynamoDbClient;
use Aws\Exception\AwsException;
use Aws\Credentials\CredentialProvider;

enum UserDataFields
{
	case Email;
	case SentDates;
}

enum UserDataReturnValues: string
{
	case Sucsess = 'Sucsess';
	case AlreadySent = 'You have already participated today';

}

class LotterySender extends AwsDynamoDB
{
	private $email;
	/**
	 * Constructor for connecting to table LotteryUsers
	 */
	public function __construct($email)
	{
		$this->connectionData = array(
			'region' => 'us-east-1',
			'version' => 'latest',
			'profile' => 'default',
			'credentials' => new Aws\Credentials\InstanceProfileProvider(),
		);
		$this->primaryField = 'Email';
		$this->tableName = 'LotteryUsers';
		$this->email = $email;
		parent::__construct();
	}

	public function SendEmail()
	{
		if ($this->CheckDate()) {
			$this->Send();
			$this->AddDate();
			return UserDataReturnValues::Sucsess;
		}
		return UserDataReturnValues::AlreadySent;
	}

	private function Send()
	{
		$message = 'Your mail accepted';
		$ses = new AwsSES();
		return $ses->SendEmail($this->email, $message);
	}

	private function GetDateInt(): int
	{
		return intval(date("Ymd"));
	}

	private function AddDate()
	{
		$currentDate = $this->GetDateInt();
		if (isset($this->data[UserDataFields::Email->name]))
		{
			$newDates = $this->data[UserDataFields::SentDates->name]['NS'];
			$newDates[] = strval($currentDate);
			$this->UpdateItem($this->email, [UserDataFields::SentDates->name], [$newDates]);
		}
		else
		{
			$this->AddItem($this->email, [UserDataFields::SentDates->name], [array($currentDate)]);
		}
	}

	private function CheckDate()
	{
		$this->GetItem($this->email);
		if (isset($this->data[UserDataFields::SentDates->name])) {
			return !$this->FindDate($this->data[UserDataFields::SentDates->name]['NS']);
		}
		return true;
	}

	private function FindDate($dates)
	{
		return in_array($this->GetDateInt(), $dates);
	}

}

?>
