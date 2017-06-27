1. Create ```/code/``` directory if it doesn't already exist in magento ```app/``` path.

2. Extract NetCents module from zip file and upload folder to ```/app/code/```
 
   Example: /app/code/NetCents

3. Run commands in SSH

   ```
   sudo php bin/magento module:enable --clear-static-content NetCents_PayGateway
   sudo php bin/magento setup:upgrade
   sudo php bin/magento setup:di:compile
   ```
   
   If you receive a memory exhausted error compile with memory_limit set.
   ```
   php -dmemory_limit=5G bin/magento setup:di:compile
   ```

4. Go to magento admin panel -> Stores -> Configuration -> Sales -> Payment Methods
   
   Select NetCents and add your live keys into the live input fields, and the same for sandbox.

