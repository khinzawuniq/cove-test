<?php

/**
 * Please, improve this class and fix all problems.
 *
 * You can change the Tenant class and its methods and properties as you want.
 * You can't change the AccountingService behavior.
 * You can choose PHP 7 or 8.
 * You can consider this class as an Eloquent model, so you are free to use
 * any Laravel methods and helpers.
 *
 * What is important:
 * - design (extensibility, testability)
 * - code cleanliness, following best practices
 * - consistency
 * - naming
 * - formatting
 *
 * Write your perfect code!
 */

namespace App\Models;

class Tenant{
    public $accountingService;
    public $id;

    function __construct($id){
        $this->accountingService = new \App\Services\AccountingService();
        $this->id = $id;
    }

    public function get_invoices()
    {
        $params = array('tenant_id' => $this->id);
        $invoices = $this->accountingService->getAllInvoices($params);
        
        if (!empty($invoices))
        {
            $ap_invoices = array();

            // Loop through all invoices and choose only ones that await payment
            foreach ($invoices as $i)
            {
                if ($i['status'] == 'awaiting-payment')
                    $ap_invoices[] = $i;
            }
            
            return $ap_invoices;
        }

        return null;
    }

    public function get_old_invoices()
    {
        $params = array('tenant_id' => $this->id);
        $invoices = $this->accountingService->getAllInvoices($params);

        if (!empty($invoices)) {
            $paid_invoices = array();

            // Loop through all invoices and choose only paid ones
            foreach ($invoices as $i)
            {
                if ($i['status'] == 'paid') {
                    $paid_invoices[] = $i;
                }
            }

            return $paid_invoices;
        }
    }

    // ...
}
