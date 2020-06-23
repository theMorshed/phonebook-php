<?php
function seed() {
    $friends = array(
        array(
            'id' => 1,
            'fname' => 'farhad',
            'lname' => 'hossain',
            'address' => 'satkania',
            'number' => '0178654378'
        ),
        array(
            'id' => 2,
            'fname' => 'kamal',
            'lname' => 'ahmed',
            'address' => 'kagria',
            'number' => '01767654378'
        ),
        array(
            'id' => 3,
            'fname' => 'forkan',
            'lname' => 'ahmed',
            'address' => 'chittagong',
            'number' => '0168654378'
        ),
        array(
            'id' => 4,
            'fname' => 'abdur',
            'lname' => 'rahim',
            'address' => 'mirassharai',
            'number' => '0198654378'
        ),
        array(
            'id' => 5,
            'fname' => 'rabiul',
            'lname' => 'hossain',
            'address' => 'sitakundo',
            'number' => '0148654378'
        ),
        array(
            'id' => 6,
            'fname' => 'rifat',
            'lname' => 'hossain',
            'address' => 'kotowali',
            'number' => '0178654378'
        )
    );
    $serializeFriends = serialize($friends);
    file_put_contents(DB_NAME, $serializeFriends, LOCK_EX);
}

function generateReport() {
    $serializedFriends = file_get_contents(DB_NAME);
    $unserialize = unserialize($serializedFriends);
    ?>
    <table>
        <?php if(filesize(DB_NAME) >= 10): ?>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Number</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php endif; ?>
        <tbody>
            <?php
                foreach($unserialize as $friend):
                    ?>
                    <tr>
                        <td><?php echo $friend['fname'] . " ". $friend['lname']; ?></td>
                        <td><?php echo $friend['address']; ?></td>
                        <td><?php echo $friend['number']; ?></td>
                        <td><a href="index.php?task=edit&id=<?php echo $friend['id']; ?>">Edit</a> | <a href="index.php?task=delete&id=<?php echo $friend['id']; ?>" id="delete">Delete</a></td>
                    </tr>
                <?php
                endforeach;
            ?>
        </tbody>
    </table>
    <?php
}

function addFriend($fname, $lname, $address, $number) {
    $serializedFriends = file_get_contents(DB_NAME);
    $unserializeFriends = unserialize($serializedFriends);
    $id = count($unserializeFriends) + 1;
    $friend = array(
        'id' => $id,
        'fname' => $fname,
        'lname' => $lname,
        'address' => $address,
        'number' => $number
    );
    if($unserializeFriends <= 0) {
        $friend = array(
            'id' => 1,
            'fname' => $fname,
            'lname' => $lname,
            'address' => $address,
            'number' => $number
        );
        $friend_array = array($friend);
        $serializedFriend = serialize($friend_array);
        file_put_contents(DB_NAME, $serializedFriend, LOCK_EX);
        header('location: index.php?task=report');
        return;
    }
    array_push($unserializeFriends, $friend);
    $serializedFriends = serialize($unserializeFriends);
    file_put_contents(DB_NAME, $serializedFriends, LOCK_EX);
    header('location: index.php?task=report');
}

function getFriend($id) {
    $serializedFriends = file_get_contents(DB_NAME);
    $unserializeFriends = unserialize($serializedFriends);
    foreach($unserializeFriends as $friend) {
        if($friend['id'] == $id) {
            return $friend;
        }
    }
}

function updateFriend($id, $fname, $lname, $address, $number) {
    $serializedFriends = file_get_contents(DB_NAME);
    $unserializeFriends = unserialize($serializedFriends);
    // foreach($unserializeFriends as $friend) {
    //     if($friend['id'] == $id) {
    //         $friend['fname'] = $fname;
    //         $friend['lname'] = $lname;
    //         $friend['address'] = $address;
    //         $friend['number'] = $number;
    //     }
    // }
    $unserializeFriends[$id - 1]['fname'] = $fname;
    $unserializeFriends[$id - 1]['lname'] = $lname;
    $unserializeFriends[$id - 1]['address'] = $address;
    $unserializeFriends[$id - 1]['number'] = $number;
    $serializedFriends = serialize($unserializeFriends);
    file_put_contents(DB_NAME, $serializedFriends, LOCK_EX);
    header('location: index.php?task=report');
}

function deleteFriend($id) {
    $serializedFriends = file_get_contents(DB_NAME);
    $unserializeFriends = unserialize($serializedFriends);
    unset($unserializeFriends[$id - 1]);
    $serializedFriends = serialize($unserializeFriends);
    file_put_contents(DB_NAME, $serializedFriends, LOCK_EX);
    header('location: index.php?task=report');
}