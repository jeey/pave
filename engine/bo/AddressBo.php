<?php /*
	Copyright 2014 Cédric Levieux, Jérémy Collot, ArmagNet

	This file is part of OpenTweetBar.

    OpenTweetBar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    OpenTweetBar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with OpenTweetBar.  If not, see <http://www.gnu.org/licenses/>.
*/

class AddressBo {
	var $pdo = null;

	function __construct($pdo) {
		$this->pdo = $pdo;
	}

	static function newInstance($pdo) {
		return new AddressBo($pdo);
	}


	function addAddress(&$address) {
		$query = "	INSERT INTO addresses
						(add_entity, add_email, add_line_1, add_line_2,
						add_zip_code, add_city, add_country_id, add_company_name)
					VALUES
						(:add_entity, :add_email, :add_line_1, :add_line_2,
						:add_zip_code, :add_city, :add_country_id, :add_company_name)	";

		$statement = $this->pdo->prepare($query);
// 		echo showQuery($query, $address);

		try {
			$statement->execute($address);

			$address["add_id"] = $this->pdo->lastInsertId();

			return true;
		}
		catch(Exception $e){
			echo 'Erreur de requète : ', $e->getMessage();
		}

		return false;
	}
}