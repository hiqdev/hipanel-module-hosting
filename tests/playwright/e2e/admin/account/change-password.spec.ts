import { test } from "@hipanel-core/fixtures";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";
import Index from "@hipanel-core/page/Index";

const account: string = "hipanel_test_user";
const newPassword: string = "12345";

test("Change password @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const accountHelper = new AccountHelper(adminPage);
  const index = new Index(adminPage);

  await accountHelper.gotoIndexAccount();
  await accountHelper.gotoAccountPage(account);

  await index.clickProfileMenuOnViewPage("Change password");
  await accountHelper.saveNewPassword(newPassword);

  await accountHelper.seeSuccessAlert("Settings saved");
});
