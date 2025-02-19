<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanySetting;


class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           
            $company = new CompanySetting();
            $company->name = "Example Company";
            $company->email = "example@gmail.com";
            $company->phone = "0181808080";
            $company->address = "GEC Circle, CTG";
            $company->website = "www.example.com";
            $company->report_header = "company_report_header";
            $company->report_footer = "company_report_footer";
            $company->manage_stock_to_sale = "No";
            $company->barcode_exists = "No";
            $company->deleted = "No";
            $company->is_admin = "Yes";
            $company->status = "Active";
            $company->save();

    }
}
