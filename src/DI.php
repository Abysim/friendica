<?php
/**
 * @copyright Copyright (C) 2010-2022, the Friendica project
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */

namespace Friendica;

use Dice\Dice;
use Psr\Log\LoggerInterface;

/**
 * This class is capable of getting all dynamic created classes
 *
 * @see https://designpatternsphp.readthedocs.io/en/latest/Structural/Registry/README.html
 */
abstract class DI
{
	/** @var Dice */
	private static $dice;

	public static function init(Dice $dice)
	{
		self::$dice = $dice;
	}

	/**
	 * Returns a clone of the current dice instance
	 * This usefull for overloading the current instance with mocked methods during tests
	 *
	 * @return Dice
	 */
	public static function getDice()
	{
		return clone self::$dice;
	}

	//
	// common instances
	//

	/**
	 * @return App
	 */
	public static function app()
	{
		return self::$dice->create(App::class);
	}

	/**
	 * @return Database\Database
	 */
	public static function dba()
	{
		return self::$dice->create(Database\Database::class);
	}

	//
	// "App" namespace instances
	//

	/**
	 * @return App\Arguments
	 */
	public static function args()
	{
		return self::$dice->create(App\Arguments::class);
	}

	/**
	 * @return App\BaseURL
	 */
	public static function baseUrl()
	{
		return self::$dice->create(App\BaseURL::class);
	}

	/**
	 * @return App\Mode
	 */
	public static function mode()
	{
		return self::$dice->create(App\Mode::class);
	}

	/**
	 * @return App\Page
	 */
	public static function page()
	{
		return self::$dice->create(App\Page::class);
	}

	/**
	 * @return App\Router
	 */
	public static function router()
	{
		return self::$dice->create(App\Router::class);
	}

	//
	// "Content" namespace instances
	//

	/**
	 * @return Content\Item
	 */
	public static function contentItem()
	{
		return self::$dice->create(Content\Item::class);
	}

	/**
	 * @return Content\Conversation
	 */
	public static function conversation()
	{
		return self::$dice->create(Content\Conversation::class);
	}

	/**
	 * @return Content\Text\BBCode\Video
	 */
	public static function bbCodeVideo()
	{
		return self::$dice->create(Content\Text\BBCode\Video::class);
	}

	//
	// "Core" namespace instances
	//

	/**
	 * @return Core\Cache\Capability\ICanCache
	 */
	public static function cache()
	{
		return self::$dice->create(Core\Cache\Capability\ICanCache::class);
	}

	/**
	 * @return Core\Config\Capability\IManageConfigValues
	 */
	public static function config()
	{
		return self::$dice->create(Core\Config\Capability\IManageConfigValues::class);
	}

	/**
	 * @return Core\PConfig\Capability\IManagePersonalConfigValues
	 */
	public static function pConfig()
	{
		return self::$dice->create(Core\PConfig\Capability\IManagePersonalConfigValues::class);
	}

	/**
	 * @return Core\Lock\Capability\ICanLock
	 */
	public static function lock()
	{
		return self::$dice->create(Core\Lock\Capability\ICanLock::class);
	}

	/**
	 * @return Core\L10n
	 */
	public static function l10n()
	{
		return self::$dice->create(Core\L10n::class);
	}

	/**
	 * @return Core\Worker\Repository\Process
	 */
	public static function process()
	{
		return self::$dice->create(Core\Worker\Repository\Process::class);
	}

	/**
	 * @return Core\Session\Capability\IHandleSessions
	 */
	public static function session()
	{
		return self::$dice->create(Core\Session\Capability\IHandleSessions::class);
	}

	/**
	 * @return \Friendica\Core\Storage\Repository\StorageManager
	 */
	public static function storageManager()
	{
		return self::$dice->create(Core\Storage\Repository\StorageManager::class);
	}

	/**
	 * @return \Friendica\Core\System
	 */
	public static function system()
	{
		return self::$dice->create(Core\System::class);
	}

	//
	// "LoggerInterface" instances
	//

	/**
	 * Flushes the Logger instance, so the factory is called again
	 * (creates a new id and retrieves the current PID)
	 */
	public static function flushLogger()
	{
		$flushDice = self::$dice
			->addRule(LoggerInterface::class, self::$dice->getRule(LoggerInterface::class))
			->addRule('$devLogger', self::$dice->getRule('$devLogger'));
		static::init($flushDice);
	}

	/**
	 * @return LoggerInterface
	 */
	public static function logger()
	{
		return self::$dice->create(LoggerInterface::class);
	}

	/**
	 * @return LoggerInterface
	 */
	public static function devLogger()
	{
		return self::$dice->create('$devLogger');
	}

	/**
	 * @return LoggerInterface
	 */
	public static function workerLogger()
	{
		return self::$dice->create(Core\Logger\Type\WorkerLogger::class);
	}

	//
	// "Factory" namespace instances
	//

	/**
	 * @return Factory\Api\Mastodon\Account
	 */
	public static function mstdnAccount()
	{
		return self::$dice->create(Factory\Api\Mastodon\Account::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Application
	 */
	public static function mstdnApplication()
	{
		return self::$dice->create(Factory\Api\Mastodon\Application::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Attachment
	 */
	public static function mstdnAttachment()
	{
		return self::$dice->create(Factory\Api\Mastodon\Attachment::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Card
	 */
	public static function mstdnCard()
	{
		return self::$dice->create(Factory\Api\Mastodon\Card::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Conversation
	 */
	public static function mstdnConversation()
	{
		return self::$dice->create(Factory\Api\Mastodon\Conversation::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Emoji
	 */
	public static function mstdnEmoji()
	{
		return self::$dice->create(Factory\Api\Mastodon\Emoji::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Error
	 */
	public static function mstdnError()
	{
		return self::$dice->create(Factory\Api\Mastodon\Error::class);
	}

	/**
	 * @return Factory\Api\Mastodon\FollowRequest
	 */
	public static function mstdnFollowRequest()
	{
		return self::$dice->create(Factory\Api\Mastodon\FollowRequest::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Relationship
	 */
	public static function mstdnRelationship()
	{
		return self::$dice->create(Factory\Api\Mastodon\Relationship::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Status
	 */
	public static function mstdnStatus()
	{
		return self::$dice->create(Factory\Api\Mastodon\Status::class);
	}

	/**
	 * @return Factory\Api\Mastodon\ScheduledStatus
	 */
	public static function mstdnScheduledStatus()
	{
		return self::$dice->create(Factory\Api\Mastodon\ScheduledStatus::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Subscription
	 */
	public static function mstdnSubscription()
	{
		return self::$dice->create(Factory\Api\Mastodon\Subscription::class);
	}

	/**
	 * @return Factory\Api\Mastodon\ListEntity
	 */
	public static function mstdnList()
	{
		return self::$dice->create(Factory\Api\Mastodon\ListEntity::class);
	}

	/**
	 * @return Factory\Api\Mastodon\Notification
	 */
	public static function mstdnNotification()
	{
		return self::$dice->create(Factory\Api\Mastodon\Notification::class);
	}

	/**
	 * @return Factory\Api\Twitter\Status
	 */
	public static function twitterStatus()
	{
		return self::$dice->create(Factory\Api\Twitter\Status::class);
	}

	/**
	 * @return Factory\Api\Twitter\User
	 */
	public static function twitterUser()
	{
		return self::$dice->create(Factory\Api\Twitter\User::class);
	}

	public static function notificationIntro(): Navigation\Notifications\Factory\Introduction
	{
		return self::$dice->create(Navigation\Notifications\Factory\Introduction::class);
	}

	//
	// "Model" namespace instances
	//
	/**
	 * @return \Friendica\Core\Worker\Repository\Process
	 */
	public static function modelProcess()
	{
		return self::$dice->create(Core\Worker\Repository\Process::class);
	}

	/**
	 * @return Model\User\Cookie
	 */
	public static function cookie()
	{
		return self::$dice->create(Model\User\Cookie::class);
	}

	/**
	 * @return Core\Storage\Capability\ICanWriteToStorage
	 */
	public static function storage()
	{
		return self::$dice->create(Core\Storage\Capability\ICanWriteToStorage::class);
	}

	/**
	 * @return Model\Log\ParsedLogIterator
	 */
	public static function parsedLogIterator()
	{
		return self::$dice->create(Model\Log\ParsedLogIterator::class);
	}

	//
	// "Module" namespace
	//

	public static function apiResponse(): Module\Api\ApiResponse
	{
		return self::$dice->create(Module\Api\ApiResponse::class);
	}

	//
	// "Network" namespace
	//

	/**
	 * @return Network\HTTPClient\Capability\ICanSendHttpRequests
	 */
	public static function httpClient()
	{
		return self::$dice->create(Network\HTTPClient\Capability\ICanSendHttpRequests::class);
	}

	//
	// "Repository" namespace
	//

	/**
	 * @return Contact\FriendSuggest\Repository\FriendSuggest;
	 */
	public static function fsuggest()
	{
		return self::$dice->create(Contact\FriendSuggest\Repository\FriendSuggest::class);
	}

	/**
	 * @return Contact\FriendSuggest\Factory\FriendSuggest;
	 */
	public static function fsuggestFactory()
	{
		return self::$dice->create(Contact\FriendSuggest\Factory\FriendSuggest::class);
	}

	/**
	 * @return Contact\Introduction\Repository\Introduction
	 */
	public static function intro()
	{
		return self::$dice->create(Contact\Introduction\Repository\Introduction::class);
	}

	/**
	 * @return Contact\Introduction\Factory\Introduction
	 */
	public static function introFactory()
	{
		return self::$dice->create(Contact\Introduction\Factory\Introduction::class);
	}

	public static function permissionSet(): Security\PermissionSet\Repository\PermissionSet
	{
		return self::$dice->create(Security\PermissionSet\Repository\PermissionSet::class);
	}

	public static function permissionSetFactory(): Security\PermissionSet\Factory\PermissionSet
	{
		return self::$dice->create(Security\PermissionSet\Factory\PermissionSet::class);
	}

	public static function profileField(): Profile\ProfileField\Repository\ProfileField
	{
		return self::$dice->create(Profile\ProfileField\Repository\ProfileField::class);
	}

	public static function profileFieldFactory(): Profile\ProfileField\Factory\ProfileField
	{
		return self::$dice->create(Profile\ProfileField\Factory\ProfileField::class);
	}

	public static function notification(): Navigation\Notifications\Repository\Notification
	{
		return self::$dice->create(Navigation\Notifications\Repository\Notification::class);
	}

	public static function notificationFactory(): Navigation\Notifications\Factory\Notification
	{
		return self::$dice->create(Navigation\Notifications\Factory\Notification::class);
	}

	public static function notify(): Navigation\Notifications\Repository\Notify
	{
		return self::$dice->create(Navigation\Notifications\Repository\Notify::class);
	}

	public static function notifyFactory(): Navigation\Notifications\Factory\Notify
	{
		return self::$dice->create(Navigation\Notifications\Factory\Notify::class);
	}

	public static function formattedNotificationFactory(): Navigation\Notifications\Factory\FormattedNotify
	{
		return self::$dice->create(Navigation\Notifications\Factory\FormattedNotify::class);
	}

	//
	// "Protocol" namespace instances
	//

	/**
	 * @return Protocol\Activity
	 */
	public static function activity()
	{
		return self::$dice->create(Protocol\Activity::class);
	}

	//
	// "Security" namespace instances
	//

	/**
	 * @return \Friendica\Security\Authentication
	 */
	public static function auth()
	{
		return self::$dice->create(Security\Authentication::class);
	}

	//
	// "Util" namespace instances
	//

	/**
	 * @return Util\ACLFormatter
	 */
	public static function aclFormatter()
	{
		return self::$dice->create(Util\ACLFormatter::class);
	}

	/**
	 * @return string
	 */
	public static function basePath()
	{
		return self::$dice->create('$basepath');
	}

	/**
	 * @return Util\DateTimeFormat
	 */
	public static function dtFormat()
	{
		return self::$dice->create(Util\DateTimeFormat::class);
	}

	/**
	 * @return Util\FileSystem
	 */
	public static function fs()
	{
		return self::$dice->create(Util\FileSystem::class);
	}

	/**
	 * @return Util\Profiler
	 */
	public static function profiler()
	{
		return self::$dice->create(Util\Profiler::class);
	}

	/**
	 * @return Util\Emailer
	 */
	public static function emailer()
	{
		return self::$dice->create(Util\Emailer::class);
	}
}
