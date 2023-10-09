import { expect, Locator, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";

export default class CrontabHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexCrontab() {
        await this.page.goto('/hosting/crontab/index');
        await expect(this.page).toHaveTitle("Crons");
    }

    async gotoCrontabPage(row: number) {
        await this.page.locator(`//tr[${row}]//td[1]//a[1]`).click();
    }

    async checkDetailViewData(crontab: object) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[1]/td')).toContainText(crontab['account']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[3]/td')).toContainText(crontab['client']);
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }
}
