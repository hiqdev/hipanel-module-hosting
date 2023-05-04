import { expect, Locator, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";

export default class BackupHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexBackup() {
        await this.page.goto('/hosting/backup/index');
        await expect(this.page).toHaveTitle("Backups");
    }

    async gotoBackupPage(rowNumber: number) {
        await this.index.clickColumnOnTable('ID', rowNumber);
    }

    async chooseRowOnTableByName(name: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue("Name", name);
        await this.index.chooseNumberRowOnTable(rowNumber);
    }

    async checkDetailViewData(backup: object) {
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[2]/td')).toContainText(backup['objectId']);
        await expect(this.page.locator('//table[contains(@class, "detail-view")]//tbody/tr[3]/td')).toContainText(backup['client']);
    }

    async deleteBackup() {
        await this.page.on('dialog', dialog => dialog.accept());
        await this.index.clickBulkButton('Delete');
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }
}
