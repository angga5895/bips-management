<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleApp::class);
        $this->call(UserAdmins::class);
        $this->call(UsersSeed::class);

        $this->call(DealerSeed::class);
        $this->call(SalesSeed::class);
        $this->call(Group::class);

        $this->call(SeedClApp::class);
        $this->call(SeedClModule::class);
        $this->call(SeedClAppMod::class);
        $this->call(SeedClPermissionAppMod::class);
        $this->call(SeedClPermissionApp::class);

        $this->call(AccountSeed::class);
        $this->call(DealerSalesSeed::class);
        $this->call(UserAccountSeed::class);
        $this->call(GroupDealerSeed::class);

    }
}
