<?php
/**
 * @copyright Copyright (C) 2010-2024, the Friendica project
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

namespace Friendica\Test\src\Factory\Api\Mastodon;

use Friendica\Content\Smilies;
use Friendica\DI;
use Friendica\Test\FixtureTest;

class EmojiTest extends FixtureTest
{
	protected function setUp(): void
	{
		parent::setUp();

		DI::config()->set('system', 'no_smilies', false);
	}

	public function testBuiltInCollection()
	{
		$emoji      = DI::mstdnEmoji();
		$collection = $emoji->createCollectionFromSmilies(Smilies::getList())->getArrayCopy(true);
		foreach ($collection as $item) {
			$this->assertTrue(preg_match('(/images/.*)', $item['url']) === 1, $item['url']);
		}
	}
}
