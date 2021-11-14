<?php
/**
 * @copyright Copyright (C) 2010-2021, the Friendica project
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

namespace Friendica\Module\Api\Mastodon\Accounts;

use Friendica\Core\System;
use Friendica\DI;
use Friendica\Model\Contact;
use Friendica\Model\User;
use Friendica\Module\BaseApi;

/**
 * @see https://docs.joinmastodon.org/methods/accounts/
 */
class Block extends BaseApi
{
	public static function post()
	{
		self::checkAllowedScope(self::SCOPE_FOLLOW);
		$uid = self::getCurrentUserID();

		if (empty(static::$parameters['id'])) {
			DI::mstdnError()->UnprocessableEntity();
		}

		$owner = User::getOwnerDataById($uid);
		if (empty($owner)) {
			DI::mstdnError()->Forbidden();
		}

		$cdata = Contact::getPublicAndUserContactID(static::$parameters['id'], $uid);
		if (empty($cdata['user'])) {
			DI::mstdnError()->RecordNotFound();
		}

		$contact = Contact::getById($cdata['user']);
		if (empty($contact)) {
			DI::mstdnError()->RecordNotFound();
		}

		Contact\User::setBlocked($cdata['user'], $uid, true);

		// Mastodon-expected behavior: relationship is severed on block
		Contact::terminateFriendship($owner, $contact);
		Contact::revokeFollow($contact);

		System::jsonExit(DI::mstdnRelationship()->createFromContactId(static::$parameters['id'], $uid)->toArray());
	}
}
