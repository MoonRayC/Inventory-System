
function openEditModal(orderID) {
    $.ajax({
        url: 'action/fetchOrder.php',
        type: 'GET',
        data: {
            orderID: orderID
        },
        dataType: 'json',
        success: function(data) {
            document.getElementById('orderID').value = data.orderID;
            document.getElementById('dueAmount').value = data.dueAmount;
            document.getElementById('currentPaid').value = data.paidAmount;
            document.getElementById('payOption').value = data.paymentOption;
            document.getElementById('payStatus').value = data.paymentStatus;

            $('#editOrder-form').modal('show');
        },
        error: function() {
            console.log('Error fetching order data.');
        }
    });
}

function openViewOrder(orderID) {
    $.ajax({
        url: 'action/fetchOrderData.php',
        method: 'GET',
        data: {
            orderID: orderID
        },
        dataType: 'json',
        success: function(response) {

            var startingOrderCode = 1000;
            var orderCode = startingOrderCode + parseInt(response.orderDetails.orderID);

            $('#orderCode').text(orderCode);
            $('#customerName').text(response.orderDetails.customerName);
            $('#customerNumber').text(response.orderDetails.customerNumber);
            $('#orderDate').text(response.orderDetails.orderDate);
            $('#paymentOption').text(response.orderDetails.paymentOption);
            $('#paymentStatus').text(response.orderDetails.paymentStatus);
            $('#shippingMethod').text(response.orderDetails.shippingMethod);
            $('#totalAmount').text(response.orderDetails.totalAmount);
            $('#discount').text(response.orderDetails.discount);
            $('#grandTotal').text(response.orderDetails.grandTotal);
            $('#paid').text(response.orderDetails.paidAmount);
            $('#dueTotal').text(response.orderDetails.dueAmount);
            $('#changeAmount').text(response.orderDetails.changeAmount);
            $('#employeeID').text(response.orderDetails.employeeID).css({
                'font-size': '10px'
            });

            var tbody = $('#viewOrder-form .modal-body tbody');
            tbody.empty();

            for (var i = 0; i < response.orderedItems.length; i++) {
                var item = response.orderedItems[i];

                var newRow = '<tr>' +
                    '<td class="text-start" style="padding-left:10%;">' + item.productName + '</td>' +
                    '<td>' + item.price + '</td>' +
                    '<td>' + item.quantity + '</td>' +
                    '<td>' + item.total + '</td>' +
                    '</tr>';

                tbody.append(newRow);
            }

            $('#viewOrder-form').modal('show');
        },
        error: function(error) {
            console.error('Error fetching order details:', error);
        }
    });
}


