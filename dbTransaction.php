try {
            DB::beginTransaction()

		//

            DB::commit()
        } catch (Exception $ex) {
		DB::rollback();
return / redirect 
        }
