<script>
import { 
    Select as SelectRoot,
    SelectTrigger as SelectTriggerRoot,
    SelectValue as SelectValueRoot,
    SelectContent as SelectContentRoot,
    SelectItem as SelectItemRoot,
} from 'radix-vue';

export default {
    components: {
        Select: SelectRoot,
        SelectTrigger: SelectTriggerRoot,
        SelectValue: SelectValueRoot,
        SelectContent: SelectContentRoot,
        SelectItem: SelectItemRoot,
    }
}
</script>

<style>
.SelectTrigger {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 0.375rem;
    border: 1px solid #e2e8f0;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    background-color: white;
    color: #1a202c;
    cursor: pointer;
    width: 100%;
}

.dark .SelectTrigger {
    background-color: #1a202c;
    border-color: #4a5568;
    color: #e2e8f0;
}

.SelectTrigger:hover {
    background-color: #f7fafc;
}

.dark .SelectTrigger:hover {
    background-color: #2d3748;
}

.SelectContent {
    overflow: hidden;
    background-color: white;
    border-radius: 0.375rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    width: var(--radix-select-trigger-width);
    max-height: var(--radix-select-content-available-height);
}

.dark .SelectContent {
    background-color: #1a202c;
    border-color: #4a5568;
}

.SelectItem {
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #1a202c;
    padding: 0.5rem 0.75rem;
    cursor: pointer;
    outline: none;
}

.dark .SelectItem {
    color: #e2e8f0;
}

.SelectItem:hover {
    background-color: #f7fafc;
}

.dark .SelectItem:hover {
    background-color: #2d3748;
}

.SelectItem[data-highlighted] {
    background-color: #edf2f7;
    color: #2d3748;
}

.dark .SelectItem[data-highlighted] {
    background-color: #2d3748;
    color: #e2e8f0;
}
</style> 