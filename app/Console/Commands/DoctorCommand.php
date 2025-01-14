<?php

namespace App\Console\Commands;

use App\Models\OrderProduct;
use App\Services\DoctorService;
use App\Services\ProductService;
use Illuminate\Console\Command;

class DoctorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ns:doctor {--fix-roles} {--fix-users-attributes} {--fix-orders-products}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will perform various tasks to fix issues on NexoPOS.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * @var DoctorService
         */
        $doctorService = app()->make( DoctorService::class );

        if ( $this->option( 'fix-roles' ) ) {
            $doctorService->restoreRoles();

            return $this->info( 'The roles where correctly restored.' );
        }

        if ( $this->option( 'fix-users-attributes' ) ) {
            $doctorService->createUserAttribute();

            return $this->info( 'The users attributes were fixed.' );
        }

        if ( $this->option( 'fix-orders-products' ) ) {
            $products = OrderProduct::where( 'total_purchase_price', 0 )->get();

            /**
             * @var ProductService
             */
            $productService = app()->make( ProductService::class );

            $this->withProgressBar( $products, function( OrderProduct $orderProduct ) use ( $productService ) {
                $orderProduct->total_purchase_price = $productService->getLastPurchasePrice( $orderProduct->product ) * $orderProduct->quantity;
                $orderProduct->save();
            });

            $this->newLine();

            $this->info( 'The products were succesfully updated' );
        }
    }
}
