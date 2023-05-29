import { expect, Locator, Page } from "@playwright/test";
import Index from "@hipanel-core/page/Index";
import Alert from "@hipanel-core/ui/Alert";

export default class BackupingHelper {
    private page: Page;
    private index: Index;

    public constructor(page: Page) {
        this.page = page;
        this.index = new Index(page);
    }

    async gotoIndexBackuping() {
        await this.page.goto('/hosting/backuping/index');
        await expect(this.page).toHaveTitle("Backup statistics");
    }

    async gotoBackupingPage(name) {
        await this.index.clickLinkOnTable('Name', name);
    }

    async chooseRowOnTableByName(name: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue("Name", name);
        await this.index.chooseNumberRowOnTable(rowNumber);
    }

    async delete() {
        this.page.on('dialog', dialog => dialog.accept());
        await this.index.clickBulkButton('Delete');
    }

    async seeSuccessAlert(message: string) {
        await Alert.on(this.page).hasText(message);
    }

    async seeBackupingStatus(name: string, status: string) {
        const rowNumber = await this.index.getRowNumberInColumnByValue('Name', name);
        await this.index.seeTextOnTable('State', rowNumber, status);
    }

    async saveUpdatedSettings() {
        await this.index.clickButton('Save');
    }
}
