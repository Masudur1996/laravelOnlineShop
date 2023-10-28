<?php

use App\Models\Category;

function categories()
{
    return Category::orderBy('name', 'ASC')
        ->where('status', '1')
        ->with('sub_categories')
        ->where('showHome', 'Yes')
        ->get();
}

const shippingPolicy =  "

All transactions on Laravel Online shop involves a shipping fee. This can either be paid by the customer, or shouldered by the seller through a free shipping promotion. Shipping Fee (Paid by Customer) is applied as a credit to the Account Statement. The amount is the one that shows up during the customer's checkout process
";
const returnPolicy = "If your product is damaged, defective, incorrect or incomplete at the time of delivery, please raise a return request on Laravel Online shop website. Return request must be raised within 14 days for Laravel Online shop items, or within 7 days for non Laravel Online shop items from the date of delivery.";
