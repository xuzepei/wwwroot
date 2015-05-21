    <table border="1px">
        <tbody>
            <tr>
                <th>编号</th>
                <th>姓名</th>
                <th>年龄</th>
                <th>性别</th>
                <th>电话</th>
                <th>介绍</th>
                <th>头像</th>
                <th>称号</th>
                <th>操作</th>
            </tr>

            <?php
            foreach ($designers as $designer)
            {
                echo '<tr><td><a href="index.php?id=' . $designer->id . '">' . $designer->id . '</a></td><td>' . $designer->name . '</td><td>' . $designer->age . '</td><td>' . $designer->gender . '</td><td>' . $designer->phone . '</td><td>' . $designer->desc . '</td><td>' . $designer->head_imaeg_url . '</td><td>' . $designer->type . '</td><td><a href="index.php?action=delete&id=' . $designer->id . '">' . 删除 . '</a></td></tr>';
            }
            ?>

        </tbody>
    </table>

