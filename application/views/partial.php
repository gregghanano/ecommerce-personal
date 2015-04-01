<tr class="gray">
    <form action="/Admins/order_id/<?=$value['order_id']?>" method="post">
        <td><input type="Submit" name="id_holder" value="<?=$value['order_id']?>"></td>
        <td><?=$value['first_name']?></td>
        <td><?=$value['order_date']?></td>
        <td><?=$value['address']?></td>
        <td>$<?=$value['products_quantity'] * $value['price']?></td>
        <td>
            <select action="/Admins/change_status" autofocus="<?=$value['order_status']?>" id="statusform" name="status" >
                <option><?=$value['order_status']?></option>
                <option>Shipped</option>
                <option>Cancelled</option>
                <option>Order in Process</option>
            </select>
        </td>
    </form>
</tr>