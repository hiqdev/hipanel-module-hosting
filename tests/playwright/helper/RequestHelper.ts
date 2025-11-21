import { expect, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import { Alert } from "@hipanel-core/shared/ui/components";

export default class IPHelper {
  private page: Page;
  private index: Index;

  public constructor(page: Page) {
    this.page = page;
    this.index = new Index(page);
  }

  async gotoIndexRequest() {
    await this.page.goto("/hosting/request/index");
    await expect(this.page).toHaveTitle("Requests");
  }

  async gotoViewPage(account: string) {
    const rowNumber = await this.index.getRowNumberInColumnByValue("Account", account);
    await this.page.locator("tr td button").nth(rowNumber - 1).click();
    await this.page.locator("div[role=\"tooltip\"] >> text=View").click();
  }

  async checkDetailViewData(request: object) {
    await expect(this.page.locator("//table[contains(@class, \"detail-view\")]//tbody/tr[2]/td")).toContainText(request["server"]);
    await expect(this.page.locator("//table[contains(@class, \"detail-view\")]//tbody/tr[3]/td")).toContainText(request["account"]);
  }

  async delete() {
    this.page.on("dialog", dialog => dialog.accept());
    await this.index.clickBulkButton("Delete");
  }

  async seeSuccessAlert(message: string) {
    await Alert.on(this.page).hasText(message);
  }
}
