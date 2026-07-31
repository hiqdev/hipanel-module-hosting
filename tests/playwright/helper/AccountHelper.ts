import { expect, Page } from "@playwright/test";
import Input from "@hipanel-core/input/Input";
import Index from "@hipanel-core/page/Index";
import { Alert } from "@hipanel-core/shared/ui/components";

export default class AccountHelper {
  private page: Page;
  private index: Index;

  public constructor(page: Page) {
    this.page = page;
    this.index = new Index(page);
  }

  async gotoIndexAccount() {
    await this.page.goto("/hosting/account/index");
    await expect(this.page).toHaveTitle("Accounts");
  }

  async gotoCreateAccount() {
    await this.page.locator("#dropdownMenu1").click();
    await this.page.locator("text=Create account >> nth=1").click();
  }

  async gotoAccountPage(account: string) {
    await this.index.clickLinkOnTable("Account", account);
  }

  async confirmEnableBlock() {
    await Input.field(this.page, "textarea[name=\"comment\"]").fill("Test enable comment");
    await this.clickButtonAndWaitForNavigation("Enable block");
  }

  async confirmDisableBlock() {
    await Input.field(this.page, "textarea[name=\"comment\"]").fill("Test disable comment");
    await this.clickButtonAndWaitForNavigation("Disable block");
  }

  async confirmDelete() {
    await this.clickButtonAndWaitForNavigation("Delete");
  }

  // These submits full-page-navigate back to the index. clickButton() alone
  // only awaits the click; if the caller then reads the table (e.g.
  // seeAccountStatus) before that navigation finishes, the read can start
  // mid-navigation and throw "Execution context was destroyed" instead of
  // reading fresh data. The navigation wait has to be attached before the
  // click fires (matches Index.clickPopoverMenu) — awaiting it afterward can
  // race the navigation's own start and resolve against the pre-click page.
  private async clickButtonAndWaitForNavigation(name: string) {
    await Promise.all([
      this.page.waitForNavigation({ waitUntil: "domcontentloaded" }),
      this.index.clickButton(name),
    ]);
  }

  async saveMailSettings(maximumLetters: string) {
    await Input.field(this.page, "#accountvalues-per_hour_limit").fill(maximumLetters);
    await this.index.clickButton("Save");
  }

  async saveAllowedIps(account, allowedIps: string) {
    const accountId = this.index.getParameterFromCurrentUrl("id");
    await Input.field(this.page, `#account-${accountId}-sshftp_ips`).fill(allowedIps);
    await this.index.clickButton("Save");
  }

  async saveSystemSettings(systemSettings) {
    const accountId = this.index.getParameterFromCurrentUrl("id");
    await Input.field(this.page, `#account-${accountId}-gid`).fill(systemSettings.group);
    await Input.field(this.page, `#account-${accountId}-uid`).fill(systemSettings.id);
    await this.index.clickButton("Save");
  }

  async saveNewPassword(newPassword) {
    const accountId = this.index.getParameterFromCurrentUrl("id");
    await Input.field(this.page, `#account-${accountId}-password`).fill(newPassword);
    await this.index.clickButton("Save");
  }

  async seeSuccessAlert(message: string) {
    await Alert.on(this.page).hasText(message);
  }

  async seeAccountStatus(account: string, status: string) {
    const rowNumber = await this.index.getRowNumberInColumnByValue("Account", account);
    const accountStatus = await this.index.seeTextOnTable("Status", rowNumber, status);
  }
}
